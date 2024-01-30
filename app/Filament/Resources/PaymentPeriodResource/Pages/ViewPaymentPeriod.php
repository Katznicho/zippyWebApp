<?php

namespace App\Filament\Resources\PaymentPeriodResource\Pages;

use App\Filament\Resources\PaymentPeriodResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPaymentPeriod extends ViewRecord
{
    protected static string $resource = PaymentPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
