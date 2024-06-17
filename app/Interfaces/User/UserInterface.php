<?php

namespace App\Interfaces\User;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserInterface
{
    public function getAllUsers(): Collection;

    public function getUser(int $id): User;

    public function createUser(array $data): User;

    public function updateUser(array $data, User $user): bool;

    public function deleteUser(User $user): ?bool;

    public function userFilter(array $validatedData): LengthAwarePaginator;
}
