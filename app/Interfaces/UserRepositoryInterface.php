<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserById($usersId);
    public function deleteUser($usersId);
    public function createUser(array $usersDetails);
    public function updateUser($usersId, array $newDetails);
    public function getFulfilledUsers();
}
