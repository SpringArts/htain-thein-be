<?php

namespace App\Interfaces\User;

use App\Models\User;

interface UserInterface
{
    public function getAllUsers();
    public function getUser(int $id);
    public function createUser(array $data);
    public function updateUser(array $data, User $user);
    public function deleteUser(User $user);
    public function userFilter(array $filters, int $limit, int $page);
}
