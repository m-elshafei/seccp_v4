<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function findUsersByIds(array $ids): Collection;
    public function findUsersByDepartmentIds(array $ids): Collection;
}
