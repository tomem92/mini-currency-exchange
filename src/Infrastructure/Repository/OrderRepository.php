<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Infrastructure\Repository;

use MiniCurrencyExchange\Application\Query\MySqlBasicQueries;
use MiniCurrencyExchange\Domain\Entity\AbstractEntity;
use MiniCurrencyExchange\Domain\Interface\RepositoryInterface;

final readonly class OrderRepository implements RepositoryInterface
{
    private const TABLE = 'order';

    public function __construct(
        private MySqlBasicQueries $queries
    ) {
    }

    /**
     * @inheritDoc
     */
    public function find(int $id): ?AbstractEntity
    {
        // TODO: Implement find() method.
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $criteria): array
    {
        // TODO: Implement findBy() method.
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $criteria): ?AbstractEntity
    {
        // TODO: Implement findOneBy() method.
    }

    /**
     * @inheritDoc
     */
    public function countBy(array $criteria): int
    {
        // TODO: Implement countBy() method.
    }

    /**
     * @return int
     */
    public static function getLastId(): int
    {
        return 2; //TODO replace with working PDO/ORM solution
    }
}
