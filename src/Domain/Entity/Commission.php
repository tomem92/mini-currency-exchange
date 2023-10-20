<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Entity;

final class Commission extends AbstractEntity
{
    public function __construct(
        int $id,
        private string $name,
        private int $percentageValue
    ) {
        parent::__construct($id);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Commission
     */
    public function setName(string $name): Commission
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getPercentageValue(): int
    {
        return $this->percentageValue;
    }

    /**
     * @param int $percentageValue
     * @return Commission
     */
    public function setPercentageValue(int $percentageValue): Commission
    {
        $this->percentageValue = $percentageValue;
        return $this;
    }
}
