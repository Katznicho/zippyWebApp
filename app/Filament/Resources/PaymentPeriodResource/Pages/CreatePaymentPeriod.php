<?php

namespace App\Filament\Resources\PaymentPeriodResource\Pages;

use App\Filament\Resources\PaymentPeriodResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePaymentPeriod extends CreateRecord
{
    protected static string $resource = PaymentPeriodResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Payment Period registered successfully')
            ->body('The payment period been registered successfully');
    }
}
