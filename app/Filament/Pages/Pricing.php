<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Pricing extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.pricing';

    protected static bool $shouldRegisterNavigation = false;

    // protected static ?string $title = null;

    protected ?string $heading = 'Gerer votre abonnement';

    protected ?string $subheading = 'Souscrire, modifier ou annuler son abonnement';
}
