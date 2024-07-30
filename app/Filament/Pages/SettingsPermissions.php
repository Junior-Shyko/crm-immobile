<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class SettingsPermissions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-cog-6-tooth';

    protected static string $view = 'filament.pages.settings-permissions';
    protected static ?string $navigationGroup = 'Configurações';
    protected static ?string $navigationLabel = 'Permissoes de usuário';


    protected static ?string $title = 'Permissão de usuários';

}
