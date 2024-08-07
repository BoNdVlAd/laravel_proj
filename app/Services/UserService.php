<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    /**
     * @return Collection
     */
    public function getAllUsers(): Collection
    {
        return User::all()->load('orders');
    }

    /**
     * @param User|null $user
     * @return User|null
     */
    public function getUserById(?User $user): ?User
    {
        return $user;
    }

    /**
     * @param array $data
     * @return User|null
     */
    public function createUser(array $data): ?User
    {
        $user = new User;
        $user->name = $data['name'] ?? null;
        $user->email = $data['email'] ?? null;
        $user->password = $data['password'] ?? null;

        $user->save();

        return $user;
    }

    /**
     * @param $user
     * @param array $data
     * @return User|null
     */
    public function updateUser($user, array $data): ?User
    {
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->password = $data['password'] ?? $user->password;

        $user->save();

        return $user;
    }

    /**
     * @param $user
     * @return string
     */
    public function deleteUser($user): string
    {
        $user->delete();
        return 'User has been deleted';
    }
}
