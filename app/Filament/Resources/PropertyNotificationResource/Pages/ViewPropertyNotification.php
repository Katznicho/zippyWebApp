<?php

namespace App\Filament\Resources\PropertyNotificationResource\Pages;

use App\Filament\Resources\PropertyNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyNotification extends ViewRecord
{
    protected static string $resource = PropertyNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
