<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function findUsersByDepartmentIds(array $ids): Collection
    {
        $employeeNames = Employee::whereIn('department_id', $ids)->pluck('name');

        // Convert to Eloquent collection to match interface expectation
        return new Collection($employeeNames->toArray());
    }
}
