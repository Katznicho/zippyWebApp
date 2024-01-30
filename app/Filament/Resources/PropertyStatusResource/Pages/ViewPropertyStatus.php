<?php

namespace App\Filament\Resources\PropertyStatusResource\Pages;

use App\Filament\Resources\PropertyStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPropertyStatus extends ViewRecord
{
    protected static string $resource = PropertyStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
