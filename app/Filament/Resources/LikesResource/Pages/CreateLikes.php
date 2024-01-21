<?php

namespace App\Filament\Resources\LikesResource\Pages;

use App\Filament\Resources\LikesResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateLikes extends CreateRecord
{
    protected static string $resource = LikesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Likes registered successfully')
            ->body('The like has been registered successfully');
    }
}
