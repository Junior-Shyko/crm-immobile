<?php

namespace App\Filament\Resources\DataPersonalResource\Pages;

use App\Filament\Resources\DataPersonalResource;
use App\Helpers\Helpers;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDataPersonal extends CreateRecord
{
    protected static string $resource = DataPersonalResource::class;
    protected static ?string $title = 'Criar dados pessoais';
    protected ?string $subheading = 'Adiciona informações sobre os dados pessoais';

    protected function getFormActions(): array
    {
        return [
            Actions\CreateAction::make('saveAnother')
                ->label('Salvar ')
                ->action('saveAnother')
                ->keyBindings(['mod+shift+s'])
                ->color('primary'),
            $this->getCancelFormAction(),
        ];
    }

    public function saveAnother()
    {
        $this->create();
         $this->redirect('../users');
        return Helpers::customNotification(
            'success',
            'Sucesso',
            'Dados Salvo com sucesso!',
            'heroicon-s-check-circle',
            'success'
        );
    }
}
