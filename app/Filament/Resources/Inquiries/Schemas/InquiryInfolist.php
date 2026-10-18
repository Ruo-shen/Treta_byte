<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InquiryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])->schema([
                    Group::make([
                        Section::make('Message')->schema([
                            TextEntry::make('message')
                                ->hiddenLabel()
                                ->extraAttributes(['class' => 'treta-message']),
                        ]),
                        Section::make('Internal notes')
                            ->description('Visible to staff only.')
                            ->schema([
                                TextEntry::make('internal_notes')
                                    ->hiddenLabel()
                                    ->placeholder('No notes yet. Use the Notes button to add some.')
                                    ->extraAttributes(['class' => 'treta-message']),
                            ]),
                    ])->columnSpan(['lg' => 2]),
                    Group::make([
                        Section::make('Sender')->schema([
                            TextEntry::make('name')->weight('semibold'),
                            TextEntry::make('email')
                                ->icon(Heroicon::OutlinedEnvelope)
                                ->copyable()
                                ->copyMessage('Email copied')
                                ->url(fn ($record) => 'mailto:'.rawurlencode($record->email)),
                            TextEntry::make('company')->placeholder('Not provided'),
                        ]),
                        Section::make('Details')->schema([
                            TextEntry::make('status')->badge(),
                            TextEntry::make('topic')->badge(),
                            TextEntry::make('created_at')->label('Received')->dateTime(),
                            TextEntry::make('notified_at')->label('Staff notified')->dateTime()->placeholder('Not sent'),
                        ]),
                    ])->columnSpan(['lg' => 1]),
                ]),
            ]);
    }
}
