<?php

namespace App\Filament\Resources\Inquiries\Schemas;

use App\Enums\InquiryStatus;
use App\Enums\InquiryTopic;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InquiryForm
{
    // Submitted fields are read-only: disabled fields are not dehydrated, so only status and notes can change.
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Submission')->columns(2)->schema([
                    TextInput::make('name')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('company')->disabled()->placeholder('—'),
                    Select::make('topic')->options(InquiryTopic::class)->disabled(),
                    Textarea::make('message')->disabled()->rows(6)->columnSpanFull(),
                    DateTimePicker::make('created_at')->label('Received')->disabled(),
                    DateTimePicker::make('notified_at')->label('Staff notified')->disabled()->placeholder('Not sent'),
                ]),
                Section::make('Handling')->schema([
                    Select::make('status')->options(InquiryStatus::class)->required(),
                    Textarea::make('internal_notes')->rows(4)->maxLength(5000),
                ]),
            ]);
    }
}
