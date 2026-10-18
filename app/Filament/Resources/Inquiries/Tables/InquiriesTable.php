<?php

namespace App\Filament\Resources\Inquiries\Tables;

use App\Enums\InquiryStatus;
use App\Enums\InquiryTopic;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class InquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('topic')->badge(),
                TextColumn::make('status')->badge(),
                IconColumn::make('notified_at')->label('Notified')->boolean()
                    ->getStateUsing(fn ($record) => $record->notified_at !== null),
                TextColumn::make('created_at')->label('Received')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(InquiryStatus::class),
                SelectFilter::make('topic')->options(InquiryTopic::class),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
