<?php

namespace App\Filament\Resources\UserDeviceResource\Pages;

use App\Filament\Resources\UserDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserDevice extends ViewRecord
{
    protected static string $resource = UserDeviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
