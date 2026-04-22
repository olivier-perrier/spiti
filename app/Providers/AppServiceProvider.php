<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::HEAD_END,
            fn (): string => Blade::render('<link rel="manifest" href="/manifest.webmanifest">'),
        );

        FilamentAsset::register([
            Css::make('custom-stylesheet', __DIR__.'/../../resources/css/custom.css'),
            Js::make('matomo', __DIR__.'/../../resources/js/matomo.js'),
        ]);

        FilamentColor::register([
            // 'danger' => Color::Red,
            // 'gray' => Color::Zinc,
            // 'info' => Color::Blue,
            'primary' => Color::Amber,
            // 'primary' => Color::rgb('rgb(255, 0, 0)'),
            // 'primary' => Color::hex('#ce1343e6'),
            // 'primary' => Color::Amber,
            // 'success' => Color::Green,
            // 'warning' => Color::Amber,
        ]);
    }
}
