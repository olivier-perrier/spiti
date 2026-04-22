<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EditProfile;
use App\Filament\Pages\Auth\Login;
use App\Filament\Pages\Auth\PasswordRequest;
use App\Filament\Pages\Pricing;
use App\Filament\Pages\Tenancy\EditTeamProfile;
use App\Filament\Pages\Tenancy\RegisterTeam;
use App\Filament\Widgets\BeneficiariesAgeChart;
use App\Filament\Widgets\BeneficiariesFamilyPie;
use App\Filament\Widgets\BeneficiariesNationalityChart;
use App\Filament\Widgets\BeneficiariesSexChart;
use App\Filament\Widgets\LotOverview;
use App\Models\Team;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->brandLogo(asset('images/logo-full.png'))
            ->brandLogoHeight('3rem')
            ->favicon('/images/logo-image.png')
            ->path('admin')
            ->spa()
            ->login(Login::class)
            ->profile(EditProfile::class)
            ->registration()
            ->passwordReset(requestAction: PasswordRequest::class)
            ->emailVerification()
            ->databaseNotifications()
            ->colors([
                'primary' => Color::generateV3Palette('#106452'),
                // 'secondary' => Color::generateV3Palette('rgb(21, 40, 57)'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // LotOverview::class,
                // Widgets\FilamentInfoWidget::class,
                // BeneficiariesNationalityChart::class,
                // BeneficiariesAgeChart::class,
                // BeneficiariesSexChart::class,
                // BeneficiariesFamilyPie::class,
            ])
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
            ])
            ->navigationGroups([
                'Structures',
                'Bénéficiaires',
            ])
            ->tenant(Team::class)
            ->tenantRegistration(RegisterTeam::class)
            ->tenantProfile(EditTeamProfile::class)
            ->tenantMenu(true)
            ->userMenuItems([
                Action::make('subscription')
                    ->label('Abonnement')
                    ->url(fn (): string => Pricing::getUrl(['tenant' => Filament::getTenant() ?? 1]))
                    ->icon('heroicon-m-rocket-launch'),
            ]);
        // ->renderHook(
        //     'panels::body.end',
        //     fn (): string => Blade::render("@vite('resources/js/app.js')"),
        // )
    }
}
