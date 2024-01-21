<?php

namespace App\Filament\Resources\AmenityResource\Pages;

use App\Filament\Resources\AmenityResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAmenity extends CreateRecord
{
    protected static string $resource = AmenityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Amenity created successfully')
            ->body('The amenity has been registered successfully');
    }
}
