<?php

namespace App\Filament\Resources\LikesResource\Pages;

use App\Filament\Resources\LikesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLikes extends ViewRecord
{
    protected static string $resource = LikesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
