<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Inquiries\InquiryResource;
use App\Models\Inquiry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Support\Str;

class LatestInquiries extends TableWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected static ?string $heading = 'Latest inquiries';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Inquiry::query()->latest())
            ->paginated(false)
            ->defaultPaginationPageOption(5)
            ->modifyQueryUsing(fn ($query) => $query->limit(5))
            ->recordUrl(fn (Inquiry $record) => InquiryResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')->weight('medium')->description(fn (Inquiry $record) => $record->email),
                TextColumn::make('message')->formatStateUsing(fn (string $state) => Str::limit($state, 90))->visibleFrom('md'),
                TextColumn::make('topic')->badge()->visibleFrom('sm'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Received')->since()->visibleFrom('sm'),
            ])
            ->emptyStateHeading('No inquiries yet')
            ->emptyStateDescription('Messages from the contact form will appear here.')
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
