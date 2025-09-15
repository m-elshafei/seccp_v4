<?php

namespace App\Strategies\UserRetrieval;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\UserRepositoryInterface;

class DepartmentUserRetrievalStrategy implements UserRetrievalStrategyInterface
{
    public function getUsers(array $ids, UserRepositoryInterface $userRepository): Collection
    {
        return $userRepository->findUsersByDepartmentIds($ids);
    }
}
