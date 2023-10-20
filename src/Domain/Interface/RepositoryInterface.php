<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Interface;

interface RepositoryInterface
{
    /**
     * @param int $id
     * @return EntityInterface|null
     */
    public function find(int $id): ?EntityInterface;

    /**
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria): array;

    /**
     * @param array $criteria
     * @return EntityInterface|null
     */
    public function findOneBy(array $criteria): ?EntityInterface;

    /**
     * @param array $criteria
     * @return int
     */
    public function countBy(array $criteria): int;
}
