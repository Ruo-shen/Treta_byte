<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('viewSite')
                ->label('View site')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->color('gray')
                ->url(fn () => url('/'), shouldOpenInNewTab: true),
            Action::make('writePost')
                ->label('Write a post')
                ->icon(Heroicon::OutlinedPencilSquare)
                ->url(fn () => PostResource::getUrl('create')),
        ];
    }
}
