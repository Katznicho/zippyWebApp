<?php

namespace App\Filament\Resources\PropertyStatusResource\Pages;

use App\Filament\Resources\PropertyStatusResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePropertyStatus extends CreateRecord
{
    protected static string $resource = PropertyStatusResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Staus registered successfully')
            ->body('The status has been registered successfully');
    }
}
