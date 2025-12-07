<?php

namespace App\Filament\Resources\HotspotResource\Pages;

use App\Filament\Resources\HotspotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotspot extends EditRecord
{
    protected static string $resource = HotspotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
