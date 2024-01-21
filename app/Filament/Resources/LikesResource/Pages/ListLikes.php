<?php

namespace App\Filament\Resources\LikesResource\Pages;

use App\Filament\Resources\LikesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLikes extends ListRecords
{
    protected static string $resource = LikesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
