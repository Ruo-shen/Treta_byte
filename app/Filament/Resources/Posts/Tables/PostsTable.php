<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->columns([
                TextColumn::make('title')->searchable()->limit(60),
                TextColumn::make('category.name')->placeholder('—'),
                TextColumn::make('status')->badge(),
                TextColumn::make('published_at')->dateTime()->sortable()->placeholder('—'),
                TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(PostStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
                self::previewAction(),
                Action::make('publish')
                    ->requiresConfirmation()
                    ->visible(fn (Post $record) => $record->status !== PostStatus::Published)
                    ->action(fn (Post $record) => $record->update(['status' => PostStatus::Published])),
                Action::make('unpublish')
                    ->color('gray')
                    ->requiresConfirmation()
                    ->visible(fn (Post $record) => $record->status === PostStatus::Published)
                    ->action(fn (Post $record) => $record->update(['status' => PostStatus::Draft])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function previewAction(): Action
    {
        return Action::make('preview')
            ->color('gray')
            ->url(fn (Post $record) => route('posts.preview', $record))
            ->openUrlInNewTab();
    }
}
