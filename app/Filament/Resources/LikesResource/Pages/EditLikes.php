<?php

namespace App\Filament\Resources\LikesResource\Pages;

use App\Filament\Resources\LikesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLikes extends EditRecord
{
    protected static string $resource = LikesResource::class;

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
