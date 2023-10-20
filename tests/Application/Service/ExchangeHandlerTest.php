<?php

declare(strict_types=1);

namespace Test\Application\Service;

use MiniCurrencyExchange\Application\Exception\InvalidOrderTypeException;
use MiniCurrencyExchange\Application\Service\ExchangeHandler;
use MiniCurrencyExchange\Application\Service\FakeCommission;
use MiniCurrencyExchange\Application\Service\FakeCurrencyRates;
use MiniCurrencyExchange\Domain\Entity\Commission;
use MiniCurrencyExchange\Domain\Entity\Currency;
use MiniCurrencyExchange\Domain\Entity\Order;
use MiniCurrencyExchange\Domain\Entity\User;
use MiniCurrencyExchange\Infrastructure\Repository\CurrencyRateRepository;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExchangeHandlerTest extends TestCase
{
    /**
     * @var ExchangeHandler
     */
    private ExchangeHandler $testClass;

    /**
     * @var User
     */
    private User $testUser;

    /**
     * @var Commission
     */
    private Commission $fakeCommission;

    /**
     * @var MockObject|CurrencyRateRepository
     */
    private MockObject|CurrencyRateRepository $mockedRepository;

    protected function setUp(): void
    {
        $this->testUser = new User(
            1,
            'test',
            'Test',
            'Tester',
            'test@tester.com',
            new \DateTime()
        );

        $faker = new FakeCommission();
        $faker->makeFakeCommission();
        $this->fakeCommission = $faker->getCommissions()[0];
    }

    /**
     * @dataProvider buyDataProvider
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param float $amount
     * @param float $expectedCommissionRate
     * @param float $expectedWithdrawalAmount
     */
    public function testBuy(
        Currency $currencyFrom,
        Currency $currencyTo,
        float $amount,
        float $expectedCommissionRate,
        float $expectedWithdrawalAmount
    ): void {
        $this->prepareMockForCurrencyRates($currencyFrom, $currencyTo);

        $this->testClass = new ExchangeHandler(
            $currencyFrom,
            $this->fakeCommission,
            $this->testUser,
            $this->mockedRepository
        );

        $this->testClass->buy($amount, $currencyTo);
        $order = $this->testClass->getOrder();

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(Order::BUY_TYPE, $order->getOrderType());
        $this->assertEquals($expectedCommissionRate, $order->getCommissionRate());
        $this->assertEquals($expectedWithdrawalAmount, $order->getWithdrawalAmount());
    }

    /**
     * @return iterable
     */
    public static function buyDataProvider(): iterable
    {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);

        yield [
            $pound,
            $euro,
            100.0,
            1,
            154.32
        ];

        yield [
            $euro,
            $pound,
            100.0,
            1,
            156.78
        ];
    }

    /**
     * @dataProvider sellDataProvider
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param float $amount
     * @param float $expectedCommissionRate
     * @param float $expectedWithdrawalAmount
     */
    public function testSell(
        Currency $currencyFrom,
        Currency $currencyTo,
        float $amount,
        float $expectedCommissionRate,
        float $expectedWithdrawalAmount
    ): void {
        $this->prepareMockForCurrencyRates($currencyFrom, $currencyTo);

        $this->testClass = new ExchangeHandler(
            $currencyFrom,
            $this->fakeCommission,
            $this->testUser,
            $this->mockedRepository
        );

        $this->testClass->sell($amount, $currencyTo);
        $order = $this->testClass->getOrder();

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(Order::SELL_TYPE, $order->getOrderType());
        $this->assertEquals($expectedCommissionRate, $order->getCommissionRate());
        $this->assertEquals($expectedWithdrawalAmount, $order->getWithdrawalAmount());
    }

    /**
     * @return iterable
     */
    public static function sellDataProvider(): iterable
    {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);

        yield [
            $pound,
            $euro,
            100.0,
            1,
            154.32
        ];

        yield [
            $euro,
            $pound,
            100.0,
            1,
            156.78
        ];
    }

    /**
     * @throws \ReflectionException|Exception
     */
    public function testSetCommissionValueForOrder(): void
    {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);
        $this->prepareMockForCurrencyRates($euro, $pound);

        $this->testClass = new ExchangeHandler(
            $euro,
            $this->fakeCommission,
            $this->testUser,
            $this->mockedRepository
        );

        $order = $this->prepareFakeOrder($euro, $pound, 'invalid type');

        $this->expectException(InvalidOrderTypeException::class);
        $this->expectExceptionMessage('OrderType invalid type doesn\'t exists');
        $methodToTest = self::getMethod('setCommissionValueForOrder');
        $methodToTest->invokeArgs($this->testClass, [$order]);
    }

    /**
     * @throws Exception
     */
    public function testSetterAndGetterForOrder(): void
    {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);
        $this->prepareMockForCurrencyRates($euro, $pound);

        $this->testClass = new ExchangeHandler(
            $euro,
            $this->fakeCommission,
            $this->testUser,
            $this->mockedRepository
        );

        $order = $this->prepareFakeOrder($euro, $pound, Order::SELL_TYPE);
        $this->testClass->setOrder($order);
        $this->assertEquals($order, $this->testClass->getOrder());
        $this->assertInstanceOf(Order::class, $this->testClass->getOrder());
    }

    /**
     * @dataProvider prepareOrderDataProvider
     * @param float $amount
     * @param Currency $wantedCurrency
     * @param string $orderType
     * @param Order $expectedOrder
     * @throws Exception
     * @throws \ReflectionException
     */
    public function testPrepareOrder(
        float $amount,
        Currency $wantedCurrency,
        string $orderType,
        Order $expectedOrder
    ): void {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);
        $this->prepareMockForCurrencyRates($euro, $pound);

        $this->testClass = new ExchangeHandler(
            $euro,
            $this->fakeCommission,
            $this->testUser,
            $this->mockedRepository
        );
        $methodToTest = self::getMethod('prepareOrder');
        $methodToTest->invokeArgs($this->testClass, [$amount, $wantedCurrency, $orderType]);
        $this->assertSame($expectedOrder->getAmount(), $amount);
        $this->assertSame($expectedOrder->getCurrencyTo(), $wantedCurrency);
        $this->assertSame($expectedOrder->getOrderType(), $orderType);
    }

    /**
     * @return iterable
     */
    public static function prepareOrderDataProvider(): iterable
    {
        $euro = new Currency(1, FakeCurrencyRates::EUR, FakeCurrencyRates::EUR_NAME);
        $pound = new Currency(2, FakeCurrencyRates::GBP, FakeCurrencyRates::GBP_NAME);

        $user = new User(
            1,
            'test',
            'Test',
            'Tester',
            'test@tester.com',
            new \DateTime()
        );

        yield [
            100.0,
            $pound,
            Order::SELL_TYPE,
            new Order(
                1,
                100.0,
                $euro,
                $pound,
                1.0,
                1.0,
                Order::SELL_TYPE,
                new \DateTime(),
                new \DateTime(),
                $user
            )
        ];

        yield [
            1234.5,
            $pound,
            Order::BUY_TYPE,
            new Order(
                1,
                1234.5,
                $euro,
                $pound,
                1.0,
                1.0,
                Order::BUY_TYPE,
                new \DateTime(),
                new \DateTime(),
                $user
            )
        ];
    }

    /**
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @throws Exception
     */
    private function prepareMockForCurrencyRates(
        Currency $currencyFrom,
        Currency $currencyTo
    ): void {
        $this->mockedRepository = $this->createMock(CurrencyRateRepository::class);
        $fakeCurrencyRates = new FakeCurrencyRates();
        $fakeCurrencyRates->makeFakeCurrencyRates();
        $rateKey = \sprintf(
            '%s_%s',
            strtolower($currencyFrom->getSymbol()),
            strtolower($currencyTo->getSymbol())
        );
        $this->mockedRepository->method('getRateByCurrencies')->willReturn($fakeCurrencyRates->getCurrencyRates()[$rateKey]);
    }

    /**
     * @param Currency $currencyFrom
     * @param Currency $currencyTo
     * @param string $orderType
     * @return Order
     */
    private function prepareFakeOrder(
        Currency $currencyFrom,
        Currency $currencyTo,
        string $orderType
    ): Order {
        return new Order(
            1,
            100,
            $currencyFrom,
            $currencyTo,
            1,
            1,
            $orderType,
            new \DateTime(),
            new \DateTime(),
            $this->testUser
        );
    }

    /**
     * @param string $name
     * @return \ReflectionMethod
     * @throws \ReflectionException
     */
    private static function getMethod(string $name): \ReflectionMethod
    {
        return (new \ReflectionClass(ExchangeHandler::class))->getMethod($name);
    }
}
