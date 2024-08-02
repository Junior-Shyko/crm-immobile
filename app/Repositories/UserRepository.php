<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use function request;

class UserRepository
{
    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserById($userId)
    {
        return User::findOrFail($userId);
    }

    public function deleteUser($userId)
    {
        User::destroy($userId);
    }

    public function createUser(array $userDetails)
    {
        return User::create($userDetails);
    }

    public function updateUser($userId, array $newDetails)
    {
        return User::whereId($userId)->update($newDetails);
    }

    public function getFulfilledUsers()
    {
        return User::where('is_fulfilled', true);
    }

    //Muda o link do sidebar dependendo do papel do usuario
    static public function adaptsNavigationUser() : array
    {
        $user = Auth::user();
        // Verifique o nível de permissão do usuário logado
        if ($user->hasRole(['super-admin', 'saas-super-admin'])) {
            $label = "Usuários";
            $url = '/admin/users';
        } else {
            $label = "Editar Dados Pessoais";
            $dtPersonal = new DataPersonalRepository($user);
            $url = $dtPersonal->redirectCreateOrEditDataPersonal();
        }
        return ['label' => $label, 'url' => $url];
    }



}
