<?php

namespace App\Filament\Resources\PanoramaResource\Pages;

use App\Filament\Resources\PanoramaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPanorama extends EditRecord
{
    protected static string $resource = PanoramaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
