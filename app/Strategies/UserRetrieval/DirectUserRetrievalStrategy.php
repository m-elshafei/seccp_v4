<?php

namespace App\Strategies\UserRetrieval;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\UserRepositoryInterface;

class DirectUserRetrievalStrategy implements UserRetrievalStrategyInterface
{
    public function getUsers(array $ids, UserRepositoryInterface $userRepository): Collection
    {
        return $userRepository->findUsersByIds($ids);
    }
}
