<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Dashboard;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('TRETA Lab')
            ->brandLogo(new HtmlString('<span class="treta-logo">TRETA<span>Lab</span></span>'))
            ->favicon(asset('favicon.ico'))
            ->font('Inter Tight')
            ->monoFont('JetBrains Mono')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->maxContentWidth(Width::SevenExtraLarge)
            ->colors([
                'primary' => [
                    50 => '#eef2fe',
                    100 => '#dde5fd',
                    200 => '#c0cffb',
                    300 => '#94adf7',
                    400 => '#6d8cf2',
                    500 => '#4a6fed',
                    600 => '#315ceb',
                    700 => '#2549cc',
                    800 => '#223ba3',
                    900 => '#213682',
                    950 => '#172250',
                ],
                'gray' => [
                    50 => '#f7f6f2',
                    100 => '#efede7',
                    200 => '#e5e4df',
                    300 => '#d2d0c9',
                    400 => '#9a9891',
                    500 => '#64625d',
                    600 => '#4f4d49',
                    700 => '#3b3c3d',
                    800 => '#2a2b2d',
                    900 => '#1b1c1e',
                    950 => '#17191b',
                ],
                'danger' => Color::hex('#b83a2e'),
                'success' => Color::hex('#4c6656'),
                'warning' => Color::hex('#b7791f'),
            ])
            ->navigationGroups([
                NavigationGroup::make('Inbox'),
                NavigationGroup::make('Journal'),
            ])
            ->userMenuItems([
                Action::make('viewSite')
                    ->label('View site')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->url(fn () => url('/'), shouldOpenInNewTab: true),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
