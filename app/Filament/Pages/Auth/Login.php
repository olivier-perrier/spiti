<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Text::make(new HtmlString('Utiliser les utilisateurs suivants <br> - admin.john@spiti.fr <br> - user.mack@spiti.fr <br> - commercial.mary@spiti.fr <br> - director.katy@spiti.fr <br> <br> Mot de passe "password"'))
                    ->color('info'),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ]);
    }
}
