<?php

namespace App\Filament\Resources\DataPersonalResource\Pages;

use App\Filament\Resources\DataPersonalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDataPersonal extends EditRecord
{
    protected static string $resource = DataPersonalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
