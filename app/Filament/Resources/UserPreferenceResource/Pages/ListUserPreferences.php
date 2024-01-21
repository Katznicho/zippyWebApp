<?php

namespace App\Filament\Resources\UserPreferenceResource\Pages;

use App\Filament\Resources\UserPreferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserPreferences extends ListRecords
{
    protected static string $resource = UserPreferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
