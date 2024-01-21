<?php

namespace App\Filament\Resources\UserAccountResource\Pages;

use App\Filament\Resources\UserAccountResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateUserAccount extends CreateRecord
{
    protected static string $resource = UserAccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('User registered successfully')
            ->body('The user has been registered successfully');
    }
}
