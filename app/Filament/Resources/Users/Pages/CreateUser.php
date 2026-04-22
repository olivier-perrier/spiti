<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Notifications\NewUserNotification;
use Filament\Notifications\Notification as FilamentNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        Notification::send($this->record, new NewUserNotification);
    }

    public function getCreatedNotification(): ?FilamentNotification
    {
        return FilamentNotification::make()
            ->title('Utilisateur ajouté')
            ->body('Un mail a été envoyé au nouvel utilisateur.')
            ->success()->send();
    }
}
