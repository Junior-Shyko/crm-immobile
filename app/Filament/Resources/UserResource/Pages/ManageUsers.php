<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageUsers extends ManageRecords implements HasMiddleware
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Usuários';
    protected ?string $subheading = 'Lista de usuários do sistema';
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Criar Usuário'),
        ];
    }
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            new Middleware(\Spatie\Permission\Middleware\RoleMiddleware::using(['super-admin','saas-super-admin'])),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('panel_access')),
        ];
    }
}
