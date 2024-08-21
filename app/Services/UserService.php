<?php

namespace App\Services;

use App\Helpers\PagintaionHelper;
use App\Models\Role;
use App\Models\User;

class UserService
{
    /**
     * @param $queryParams
     * @return array
     */
    public function getAllUsers($queryParams): array
    {
        $query = User::query();

        if (isset($queryParams['name'])) {
            $query->where('name', 'LIKE', "%{$queryParams['name']}%");
        }

        if (isset($queryParams['email'])) {
            $query->where('email', 'LIKE', "%{$queryParams['email']}%");
        }

        $users = $query->get();

        $showPerPage = $queryParams['perPage'] ?? 10;

        $paginated = PagintaionHelper::paginate($users, $showPerPage, $queryParams);

        return $paginated;
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

        $user->roles()->attach(Role::where('slug','customer')->first());
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
}
