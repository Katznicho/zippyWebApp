<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ViewImages extends Page
{
    use InteractsWithRecord;
    protected static string $resource = PropertyResource::class;

    protected static string $view = 'filament.resources.property-resource.pages.view-images';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        static::authorizeResourceAccess();
    }
}
