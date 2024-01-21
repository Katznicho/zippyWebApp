<?php

namespace App\Filament\Resources\UserPreferenceResource\Pages;

use App\Filament\Resources\UserPreferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUserPreference extends ViewRecord
{
    protected static string $resource = UserPreferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
