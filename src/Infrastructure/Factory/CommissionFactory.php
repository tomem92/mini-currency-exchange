<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Infrastructure\Factory;

use MiniCurrencyExchange\Domain\Entity\Commission;
use MiniCurrencyExchange\Domain\Interface\EntityInterface;
use MiniCurrencyExchange\Domain\Interface\FactoryInterface;

final class CommissionFactory implements FactoryInterface
{
    /**
     * @inheritDoc
     */
    public static function create(array $data): EntityInterface
    {
        return new Commission(
            $data[0],
            $data[1],
            $data[2]
        );
    }
}
