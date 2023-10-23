<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Application\Service;

use MiniCurrencyExchange\Application\Exception\InvalidOrderTypeException;
use MiniCurrencyExchange\Domain\Entity\Commission;
use MiniCurrencyExchange\Domain\Entity\Currency;
use MiniCurrencyExchange\Domain\Entity\Order;
use MiniCurrencyExchange\Domain\Entity\User;
use MiniCurrencyExchange\Infrastructure\Repository\CurrencyRateRepository;
use MiniCurrencyExchange\Infrastructure\Repository\OrderRepository;

final class ExchangeHandler
{
    /**
     * @var Order
     */
    private Order $order;

    public function __construct(
        private readonly Currency $currency,
        private readonly Commission $commission,
        private readonly User $user,
        private readonly CurrencyRateRepository $currencyRateRepository
    ) {
    }

    /**
     * @param float $amount
     * @param Currency $wantedCurrency
     */
    public function buy(
        float $amount,
        Currency $wantedCurrency
    ): void {
        $this->prepareOrder(
            $amount,
            $wantedCurrency,
            Order::BUY_TYPE
        );

        $this->setCommissionValueForOrder();
        $this->getOrder()->setWithdrawalAmount();
    }

    /**
     * @param float $amount
     * @param Currency $wantedCurrency
     */
    public function sell(
        float $amount,
        Currency $wantedCurrency
    ): void {
        $this->prepareOrder(
            $amount,
            $wantedCurrency,
            Order::SELL_TYPE
        );

        $this->getOrder()->setWithdrawalAmount();
        $this->setCommissionValueForOrder();
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return ExchangeHandler
     */
    public function setCurrency(Currency $currency): ExchangeHandler
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return Commission
     */
    public function getCommission(): Commission
    {
        return $this->commission;
    }

    /**
     * @param Commission $commission
     * @return ExchangeHandler
     */
    public function setCommission(Commission $commission): ExchangeHandler
    {
        $this->commission = $commission;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return ExchangeHandler
     */
    public function setUser(User $user): ExchangeHandler
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return CurrencyRateRepository
     */
    public function getCurrencyRateRepository(): CurrencyRateRepository
    {
        return $this->currencyRateRepository;
    }

    /**
     * @param CurrencyRateRepository $currencyRateRepository
     * @return ExchangeHandler
     */
    public function setCurrencyRateRepository(CurrencyRateRepository $currencyRateRepository): ExchangeHandler
    {
        $this->currencyRateRepository = $currencyRateRepository;
        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     * @return ExchangeHandler
     */
    public function setOrder(Order $order): ExchangeHandler
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @param float $amount
     * @param Currency $wantedCurrency
     * @param string $orderType
     * @throws \DomainException
     */
    private function prepareOrder(
        float $amount,
        Currency $wantedCurrency,
        string $orderType
    ): void {
        $currencyRate = $this->getCurrencyRateRepository()->getRateByCurrencies($this->currency, $wantedCurrency);
        if (null === $currencyRate) {
            throw new \DomainException('Cannot fetch currency rate.');
        }

        $this->setOrder(
            new Order(
                OrderRepository::getLastId() + 1,
                $amount,
                $this->getCurrency(),
                $wantedCurrency,
                $this->commission->getPercentageValue(),
                $currencyRate->getRate(),
                $orderType,
                new \DateTime(),
                new \DateTime(),
                $this->getUser()
            )
        );
    }

    /**
     * @throws InvalidOrderTypeException
     */
    private function setCommissionValueForOrder(): void
    {
        $order = $this->getOrder();
        $orderType = $order->getOrderType();

        $amountToBeCommissioned = match ($orderType) {
            Order::BUY_TYPE => $order->getAmount(),
            Order::SELL_TYPE => $order->getWithdrawalAmount(),
            default => throw new InvalidOrderTypeException(\sprintf('OrderType %s doesn\'t exists', $orderType))
        };

        $order->setCommissionValue($amountToBeCommissioned * $order->getCommissionRate());
    }
}
