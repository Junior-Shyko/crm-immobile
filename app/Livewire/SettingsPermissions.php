<?php

namespace App\Livewire;

use App\Models\User;
use App\Repositories\UserRepository;
use Livewire\Component;
use \Spatie\Permission\Models\Role;
use App\Interfaces\UserRepositoryInterface;

class SettingsPermissions extends Component
{

    public $roles = [];

    public int $idUser = 0;

    public $nameRole = "";

    public string $permission;

    public function render()
    {
        return view('livewire.settings-permissions');
    }

    public function mount()
    {
        $this->roles = Role::all();
    }


    public function setPermissions($id)
    {
        $user =  User::findOrFail($id);
//        $user->givePermissionTo('edit articles');
        dump($user);
        dump($this->permission);
//        return $this->idUser = $user->id;
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
