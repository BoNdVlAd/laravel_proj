<?php

namespace App\Services;

use App\Models\Role;
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

    /**
     * @param $role
     * @return string
     */
    public function checkRole($role): string
    {
        $user = auth()->user();
        if($user->hasRole($role)) {
            return 'true';
        }
        return 'false';
    }


    /**
     * @param $role
     * @return string
     */
    public function editRole($role): string
    {
        $user = auth()->user();
        $user->roles()->detach();
        $user->roles()->attach(Role::where('slug',$role)->first());

        return 'Role has been changed';
    }

    /**
     * @param $data
     * @return string
     */
    public function changePassword($data): string
    {
        $user = auth()->user();

        if (!password_verify($data['old_password'], $user->password)) {
            return 'Wrong old password';
        }

        $user->password = $data['new_password'];

        $user->save();

        return 'Password has been changed';
    }
}
