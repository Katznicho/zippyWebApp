<?php

namespace App\Filament\Resources\IndividualCustomerResource\Pages;

use App\Filament\Resources\IndividualCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIndividualCustomer extends EditRecord
{
    protected static string $resource = IndividualCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
