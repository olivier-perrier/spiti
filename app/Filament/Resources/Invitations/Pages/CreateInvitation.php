<?php

namespace App\Filament\Resources\Invitations\Pages;

use App\Filament\Resources\Invitations\InvitationResource;
use App\Notifications\InvitationNotification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CreateInvitation extends CreateRecord
{
    protected static string $resource = InvitationResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['token'] = Str::random();

        return $data;
    }

    public function afterCreate()
    {
        $invitation = $this->getRecord();

        Notification::route('mail', [$invitation->email])->notify(new InvitationNotification($invitation));
    }

    public function getRedirectUrl(): string
    {
        return InvitationResource::getUrl('index');
    }
}
