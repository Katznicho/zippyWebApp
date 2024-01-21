<?php

namespace App\Filament\Resources\PropertyNotificationResource\Pages;

use App\Filament\Resources\PropertyNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyNotification extends EditRecord
{
    protected static string $resource = PropertyNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
