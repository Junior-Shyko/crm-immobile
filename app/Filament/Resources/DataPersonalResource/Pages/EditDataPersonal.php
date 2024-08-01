<?php

namespace App\Filament\Resources\DataPersonalResource\Pages;

use App\Filament\Resources\DataPersonalResource;
use App\Helpers\Helpers;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use function auth;

class EditDataPersonal extends EditRecord
{
    protected static string $resource = DataPersonalResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Helpers::customNotification(
            'success',
            'Sucesso',
            'Dados pessoais registrados com sucesso!',
            'heroicon-s-check-circle',
            'success'
        );

    }



}
