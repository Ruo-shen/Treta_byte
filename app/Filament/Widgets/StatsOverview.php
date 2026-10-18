<?php

namespace App\Filament\Widgets;

use App\Enums\InquiryStatus;
use App\Enums\PostStatus;
use App\Filament\Resources\Inquiries\InquiryResource;
use App\Filament\Resources\Posts\PostResource;
use App\Models\Inquiry;
use App\Models\Post;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $new = Inquiry::where('status', InquiryStatus::New)->count();
        $month = Inquiry::where('created_at', '>=', now()->startOfMonth())->count();
        $published = Post::published()->count();
        $drafts = Post::where('status', PostStatus::Draft)->count();
        $scheduled = Post::where('status', PostStatus::Published)->where('published_at', '>', now())->count();

        return [
            Stat::make('New inquiries', $new)
                ->description($new > 0 ? 'Waiting for a reply' : 'Inbox is clear')
                ->descriptionIcon($new > 0 ? Heroicon::Sparkles : Heroicon::CheckCircle)
                ->color($new > 0 ? 'primary' : 'success')
                ->url(InquiryResource::getUrl('index', ['filters' => ['status' => ['value' => InquiryStatus::New->value]]])),
            Stat::make('Inquiries this month', $month)
                ->description(now()->format('F Y'))
                ->url(InquiryResource::getUrl()),
            Stat::make('Published posts', $published)
                ->description('Live on the journal')
                ->url(PostResource::getUrl()),
            Stat::make('Drafts and scheduled', $drafts + $scheduled)
                ->description("{$drafts} draft, {$scheduled} scheduled")
                ->url(PostResource::getUrl()),
        ];
    }

    protected function getColumns(): int|array|null
    {
        return ['default' => 2, 'lg' => 4];
    }
}
