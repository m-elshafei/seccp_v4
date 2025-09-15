<?php

namespace App\Strategies\UserRetrieval;

use Illuminate\Database\Eloquent\Collection;
use App\Contracts\UserRepositoryInterface;

interface UserRetrievalStrategyInterface
{
    public function getUsers(array $ids, UserRepositoryInterface $userRepository): Collection;
}
