<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Application\Service;

use MiniCurrencyExchange\Domain\Entity\Currency;
use MiniCurrencyExchange\Infrastructure\Factory\CurrencyFactory;
use MiniCurrencyExchange\Infrastructure\Factory\CurrencyRateFactory;

final class FakeCurrencyRates
{
    public const EUR = 'EUR';
    public const GBP = 'GBP';
    public const EUR_NAME = 'euro';
    public const GBP_NAME = 'pound';
    public const EUR_GBP = 1.5678;
    public const GBP_EUR = 1.5432;

    public function __construct(
        private array $currencyRates = []
    ) {
    }

    public function makeFakeCurrencyRates(): void
    {
        $eur = CurrencyFactory::create([1, self::EUR, FakeCurrencyRates::EUR_NAME]);
        $gbp = CurrencyFactory::create([2, self::GBP, FakeCurrencyRates::GBP_NAME]);

        $this->currencyRates['eur_gbp'] = CurrencyRateFactory::create([1, $eur, $gbp, self::EUR_GBP]);
        $this->currencyRates['gbp_eur'] = CurrencyRateFactory::create([2, $gbp, $eur, self::GBP_EUR]);
    }

    /**
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param float $rate
     */
    public function addCurrencyRate(Currency $currencyFrom, Currency $currencyTo, float $rate): void
    {
        $keyFrom = strtolower($currencyFrom->getSymbol());
        $keyTo = strtolower($currencyTo->getSymbol());
        $key = \sprintf('%s_%s', $keyFrom, $keyTo);

        $this->currencyRates[$key] = CurrencyRateFactory::create([3, $currencyFrom, $currencyTo, $rate]);
    }

    /**
     * @return array
     */
    public function getCurrencyRates(): array
    {
        return $this->currencyRates;
    }
}
