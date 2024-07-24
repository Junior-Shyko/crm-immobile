<?php

namespace App\Livewire;

use Livewire\Component;
use \Spatie\Permission\Models\Role;

class SettingsPermissions extends Component
{
    public $roles = [];

    public $nameRole = "";

    public function render()
    {
        return view('livewire.settings-permissions');
    }

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function updatedRolesTeste($role)
    {
       $item = "";
       switch ($role) {
           case 'common':
               return  "Comum";
               break;
           case 'manager':
               return "Gerente";
               break;
           case 'super-admin':
               return "Super Administrador";
               break;
           case 'saas-super-admin':
               return "Saas Super Administrador";
               break;
       }
    }
}
