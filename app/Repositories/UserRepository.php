<?php

namespace App\Repositories;

use App\Models\User;
use App\Enums\UserRole;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Override;

class UserRepository implements UserRepositoryInterface
{

    public function create(array $data): User
    {
        return User::create($data);
    }


    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    #[Override]
    public function  updateRole(int $id, UserRole $role): bool
    {
        return User::where('id', $id)->update([
            'role' => $role->value
        ]);
    }

    #[Override]
    public function getPaginated(int $perPage): LengthAwarePaginator
    {
        return User::latest()->paginate($perPage);
    }
}
