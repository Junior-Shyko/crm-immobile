<?php

namespace App\Filament\Resources\DataPersonalResource\Pages;

use App\Filament\Resources\DataPersonalResource;
use Filament\Resources\Pages\Page;

class UserDataPersonal extends Page
{
    protected static string $resource = DataPersonalResource::class;

    protected static string $view = 'filament.resources.data-personal-resource.pages.user-data-personal';
}
