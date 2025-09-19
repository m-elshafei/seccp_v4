<?php

namespace App\Strategies\UserRetrieval;

use InvalidArgumentException;

class UserRetrievalStrategyFactory
{
    private const STRATEGY_MAPPINGS = [
        'User' => DirectUserRetrievalStrategy::class,
        'Department' => DepartmentUserRetrievalStrategy::class,
    ];

    public static function create(string $type): UserRetrievalStrategyInterface
    {
        $strategyClass = self::STRATEGY_MAPPINGS[$type] ?? null;

        if (! $strategyClass) {
            throw new InvalidArgumentException("Unsupported user retrieval type: {$type}");
        }

        return new $strategyClass;
    }
}
