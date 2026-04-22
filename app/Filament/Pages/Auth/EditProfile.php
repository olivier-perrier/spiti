<?php

namespace App\Filament\Pages\Auth;

use Filament\Facades\Filament;
use Filament\Forms\Form;

class EditProfile extends \Filament\Auth\Pages\EditProfile
{
    public static function getLabel(): string
    {
        return Filament::auth()->user()->name;
    }

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             $this->getNameFormComponent(),
    //             $this->getEmailFormComponent(),
    //             $this->getPasswordFormComponent(),
    //             $this->getPasswordConfirmationFormComponent(),
    //         ]);
    // }
}
