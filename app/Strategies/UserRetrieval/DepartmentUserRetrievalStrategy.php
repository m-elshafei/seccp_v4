<?php

namespace App\Strategies\UserRetrieval;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DepartmentUserRetrievalStrategy implements UserRetrievalStrategyInterface
{
    public function getUsers(array $ids, UserRepositoryInterface $userRepository): Collection
    {
        return $userRepository->findUsersByDepartmentIds($ids);
    }
}
