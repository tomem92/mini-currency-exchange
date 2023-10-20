<?php

declare(strict_types=1);

namespace Test\Application\Service;

use MiniCurrencyExchange\Application\Service\FakeCurrencyRates;
use MiniCurrencyExchange\Domain\Entity\Currency;
use MiniCurrencyExchange\Domain\Entity\CurrencyRate;
use PHPUnit\Framework\TestCase;

final class FakeCurrencyRatesTest extends TestCase
{
    /**
     * @var FakeCurrencyRates
     */
    private FakeCurrencyRates $testClass;

    public function setUp(): void
    {
        $this->testClass = new FakeCurrencyRates();
    }

    /**
     * @dataProvider makeFakeCurrencyRatesDataProvider
     * @param string $expectedKey
     * @param int $expectedId
     * @param float $expectedRate
     * @param Currency $expectedCurrencyFrom
     * @param Currency $expectedCurrencyTo
     */
    public function testMakeFakeCurrencyRates(
        string $expectedKey,
        int $expectedId,
        float $expectedRate,
        Currency $expectedCurrencyFrom,
        Currency $expectedCurrencyTo
    ): void {
        $this->testClass->makeFakeCurrencyRates();
        /** @var array<CurrencyRate> $currencyRates */
        $currencyRates = $this->testClass->getCurrencyRates();

        $this->assertCount(2, $currencyRates);
        $this->assertSame($expectedId, $currencyRates[$expectedKey]->getId());
        $this->assertSame($expectedRate, $currencyRates[$expectedKey]->getRate());
        $this->assertInstanceOf(Currency::class, $expectedCurrencyFrom);
        $this->assertSame($expectedCurrencyFrom->getId(), $currencyRates[$expectedKey]->getCurrencyFrom()->getId());
        $this->assertSame($expectedCurrencyFrom->getSymbol(), $currencyRates[$expectedKey]->getCurrencyFrom()->getSymbol());
        $this->assertSame($expectedCurrencyFrom->getName(), $currencyRates[$expectedKey]->getCurrencyFrom()->getName());
        $this->assertInstanceOf(Currency::class, $expectedCurrencyTo);
        $this->assertSame($expectedCurrencyTo->getId(), $currencyRates[$expectedKey]->getCurrencyTo()->getId());
        $this->assertSame($expectedCurrencyTo->getSymbol(), $currencyRates[$expectedKey]->getCurrencyTo()->getSymbol());
        $this->assertSame($expectedCurrencyTo->getName(), $currencyRates[$expectedKey]->getCurrencyTo()->getName());
    }

    public static function makeFakeCurrencyRatesDataProvider(): iterable
    {
        $testObjects = [];

        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);

        $testObjects[] = new CurrencyRate(
            1,
            $euro,
            $pound,
            FakeCurrencyRates::EUR_GBP
        );

        $testObjects[] = new CurrencyRate(
            2,
            $pound,
            $euro,
            FakeCurrencyRates::GBP_EUR
        );

        foreach ($testObjects as $testObject) {
            yield [
                \sprintf(
                    '%s_%s',
                    strtolower($testObject->getCurrencyFrom()->getSymbol()),
                    strtolower($testObject->getCurrencyTo()->getSymbol())
                ),
                $testObject->getId(),
                $testObject->getRate(),
                $testObject->getCurrencyFrom(),
                $testObject->getCurrencyTo()
            ];
        }
    }

    public function testEmptyCurrencyRates(): void
    {
        $fakeCurrencyRates = new FakeCurrencyRates();

        $this->assertEmpty($fakeCurrencyRates->getCurrencyRates());
    }
}
