<?php

namespace App\Filament\Resources\PropertyNotificationResource\Pages;

use App\Filament\Resources\PropertyNotificationResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyNotification extends CreateRecord
{
    protected static string $resource = PropertyNotificationResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Property Notification registered successfully')
            ->body('The property notification has been registered successfully');
    }
}
