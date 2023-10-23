<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Entity;

final readonly class CurrencyRate extends AbstractEntity
{
    public function __construct(
        int $id,
        private Currency $currencyFrom,
        private Currency $currencyTo,
        private float $rate
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
     * @return Currency
     */
    public function getCurrencyFrom(): Currency
    {
        return $this->currencyFrom;
    }

    /**
     * @param Currency $currencyFrom
     * @return CurrencyRate
     */
    public function setCurrencyFrom(Currency $currencyFrom): CurrencyRate
    {
        $this->currencyFrom = $currencyFrom;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrencyTo(): Currency
    {
        return $this->currencyTo;
    }

    /**
     * @param Currency $currencyTo
     * @return CurrencyRate
     */
    public function setCurrencyTo(Currency $currencyTo): CurrencyRate
    {
        $this->currencyTo = $currencyTo;
        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return CurrencyRate
     */
    public function setRate(float $rate): CurrencyRate
    {
        $this->rate = $rate;
        return $this;
    }
}
