<?php

namespace App\Strategies\UserRetrieval;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface UserRetrievalStrategyInterface
{
    public function getUsers(array $ids, UserRepositoryInterface $userRepository): Collection;
}
