<?php

namespace App\Filament\Resources\PaymentPeriodResource\Pages;

use App\Filament\Resources\PaymentPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaymentPeriod extends EditRecord
{
    protected static string $resource = PaymentPeriodResource::class;

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
