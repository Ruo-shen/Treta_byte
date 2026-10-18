<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('featured_image_path')
                    ->label('Image')
                    ->disk('public')
                    ->imageSize(48)
                    ->extraImgAttributes(['class' => 'rounded-md object-cover'])
                    ->visibleFrom('sm'),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('medium')
                    ->limit(70)
                    ->description(fn (Post $record) => $record->category?->name),
                TextColumn::make('status')
                    ->badge()
                    ->state(fn (Post $record) => self::isScheduled($record) ? 'Scheduled' : $record->status->getLabel())
                    ->color(fn (Post $record) => self::isScheduled($record) ? 'warning' : $record->status->getColor()),
                TextColumn::make('published_at')->label('Publish date')->dateTime('j M Y')->sortable()->placeholder('—')->visibleFrom('md'),
                TextColumn::make('updated_at')->label('Edited')->since()->sortable()->visibleFrom('lg'),
            ])
            ->filters([
                SelectFilter::make('status')->options(PostStatus::class),
                SelectFilter::make('category')->relationship('category', 'name')->preload(),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make(),
                    self::previewAction(),
                    Action::make('publish')
                        ->icon(Heroicon::OutlinedArrowUpCircle)
                        ->requiresConfirmation()
                        ->visible(fn (Post $record) => $record->status !== PostStatus::Published)
                        ->action(fn (Post $record) => $record->update(['status' => PostStatus::Published])),
                    Action::make('unpublish')
                        ->icon(Heroicon::OutlinedArrowDownCircle)
                        ->requiresConfirmation()
                        ->visible(fn (Post $record) => $record->status === PostStatus::Published)
                        ->action(fn (Post $record) => $record->update(['status' => PostStatus::Draft])),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No posts yet')
            ->emptyStateDescription('Write the first article for the journal. It stays a draft until you publish it.')
            ->emptyStateIcon(Heroicon::OutlinedDocumentText)
            ->emptyStateActions([
                CreateAction::make()->label('Write a post'),
            ]);
    }

    public static function previewAction(): Action
    {
        return Action::make('preview')
            ->icon(Heroicon::OutlinedEye)
            ->color('gray')
            ->url(fn (Post $record) => route('posts.preview', $record))
            ->openUrlInNewTab();
    }

    private static function isScheduled(Post $post): bool
    {
        return $post->status === PostStatus::Published && (bool) $post->published_at?->isFuture();
    }
}
