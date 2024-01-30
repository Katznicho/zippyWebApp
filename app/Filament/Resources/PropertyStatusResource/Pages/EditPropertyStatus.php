<?php

namespace App\Filament\Resources\PropertyStatusResource\Pages;

use App\Filament\Resources\PropertyStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPropertyStatus extends EditRecord
{
    protected static string $resource = PropertyStatusResource::class;

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
