<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Infrastructure\Repository;

use MiniCurrencyExchange\Application\Query\MySqlBasicQueries;
use MiniCurrencyExchange\Application\Service\FakeCurrencyRates;
use MiniCurrencyExchange\Domain\Entity\AbstractEntity;
use MiniCurrencyExchange\Domain\Entity\Currency;
use MiniCurrencyExchange\Domain\Entity\CurrencyRate;
use MiniCurrencyExchange\Domain\Interface\RepositoryInterface;

class CurrencyRateRepository implements RepositoryInterface
{
    private const TABLE = 'currencyRate';

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
    public function getLastId(): int
    {
        return 2; //TODO replace with working PDO/ORM solution
    }

    public function getRateByCurrencies(
        Currency $currencyFrom,
        Currency $currencyTo
    ): ?CurrencyRate {
        //TODO connect this to ORM/PDO
        //        return $this->findOneBy(
        //            [
        //                'currencyFrom' => $currencyFrom,
        //                'currencyTo' => $currencyTo
        //            ]
        //        );

        $fakeCurrencyRates = new FakeCurrencyRates();
        $fakeCurrencyRates->makeFakeCurrencyRates();
        $rateKey = \sprintf(
            '%s_%s',
            strtolower($currencyFrom->getSymbol()),
            strtolower($currencyTo->getSymbol())
        );

        return $fakeCurrencyRates->getCurrencyRates()[$rateKey];
    }
}
