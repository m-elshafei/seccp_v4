<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\UserRepositoryInterface;
use App\Models\User;
use App\Models\Employee;

class UserRepository implements UserRepositoryInterface
{
    public function findUsersByIds(array $ids): Collection
    {
        return User::whereIn('id', $ids)->get();
    }

    public function findUsersByDepartmentIds(array $ids): Collection
    {
        $employees = Employee::whereIn('department_id', $ids)
            ->whereNotNull('user_id')
            ->with('user')
            ->get();

        return $employees->pluck('user')->filter();
    }
}
