<?php

namespace App\Filament\Resources\UserDeviceResource\Pages;

use App\Filament\Resources\UserDeviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserDevice extends EditRecord
{
    protected static string $resource = UserDeviceResource::class;

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
