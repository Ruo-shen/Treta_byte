<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Enums\InquiryStatus;
use App\Enums\InquiryTopic;
use App\Models\Inquiry;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordClasses(fn (Inquiry $record) => $record->status === InquiryStatus::New ? 'treta-row-new' : null)
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->weight(fn (Inquiry $record) => $record->status === InquiryStatus::New ? 'bold' : 'medium')
                    ->description(fn (Inquiry $record) => $record->email),
                TextColumn::make('message')
                    ->label('Message')
                    ->formatStateUsing(fn (string $state) => Str::limit(Str::squish($state), 100))
                    ->searchable()
                    ->wrap()
                    ->visibleFrom('lg'),
                TextColumn::make('topic')->badge()->visibleFrom('md'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Received')->since()->sortable()
                    ->tooltip(fn (Inquiry $record) => $record->created_at->format('j M Y, H:i'))
                    ->visibleFrom('sm'),
            ])
            ->filters([
                SelectFilter::make('status')->options(InquiryStatus::class),
                SelectFilter::make('topic')->options(InquiryTopic::class),
            ])
            ->recordActions([
                ViewAction::make()->iconButton()->tooltip('Open'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('markRead')
                        ->label('Mark as read')
                        ->icon(Heroicon::OutlinedEye)
                        ->deselectRecordsAfterCompletion()
                        ->action(fn (Collection $records) => $records
                            ->each(function (Inquiry $record) {
                                if ($record->status === InquiryStatus::New) {
                                    $record->update(['status' => InquiryStatus::Read]);
                                }
                            })),
                ]),
            ])
            ->emptyStateHeading('No inquiries yet')
            ->emptyStateDescription('Messages sent from the contact form land here. Nothing to answer right now.')
            ->emptyStateIcon(Heroicon::OutlinedInboxArrowDown);
    }
}
