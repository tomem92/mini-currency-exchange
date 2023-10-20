<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Entity;

use MiniCurrencyExchange\Domain\Interface\EntityInterface;

abstract class AbstractEntity implements EntityInterface
{
    public function __construct(
        protected int $id
    ) {
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->id;
    }
}
