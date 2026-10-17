<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                        if (blank($get('slug'))) {
                            $set('slug', Str::slug((string) $state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(100)
                    ->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')
                    ->unique(ignoreRecord: true)
                    ->validationMessages([
                        'regex' => 'Use lowercase letters, numbers and single hyphens only.',
                        'unique' => 'Another category already uses this slug.',
                    ]),
            ]);
    }
}
