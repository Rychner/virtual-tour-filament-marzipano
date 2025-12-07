<?php

namespace App\Filament\Resources\PanoramaResource\Pages;

use App\Filament\Resources\PanoramaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPanoramas extends ListRecords
{
    protected static string $resource = PanoramaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
