<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Interface;

interface FactoryInterface
{
    /**
     * @param array $data
     * @return EntityInterface
     */
    public static function create(array $data): EntityInterface;
}
