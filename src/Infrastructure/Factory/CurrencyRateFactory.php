<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Infrastructure\Factory;

use MiniCurrencyExchange\Domain\Entity\CurrencyRate;
use MiniCurrencyExchange\Domain\Interface\EntityInterface;
use MiniCurrencyExchange\Domain\Interface\FactoryInterface;

final class CurrencyRateFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public static function create(array $data): EntityInterface
    {
        return new CurrencyRate(
            $data[0],
            $data[1],
            $data[2],
            $data[3]
        );
    }
}
