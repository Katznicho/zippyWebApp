<?php

namespace App\Filament\Resources\IndividualCustomerResource\Pages;

use App\Filament\Resources\IndividualCustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIndividualCustomers extends ListRecords
{
    protected static string $resource = IndividualCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
