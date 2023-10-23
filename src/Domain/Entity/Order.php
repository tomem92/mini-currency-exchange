<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Entity;

use MiniCurrencyExchange\Domain\Interface\EntityInterface;

final class Order implements EntityInterface
{
    public const BUY_TYPE = 'buy';  //todo move these types to separate OrderType entity/enum & repo
    public const SELL_TYPE = 'sell';

    /**
     * @var float
     */
    private float $commissionValue;

    /**
     * @var float
     */
    private float $withdrawalAmount;

    public function __construct(
        private readonly int $id,
        private readonly float $amount,
        private readonly Currency $currencyFrom,
        private readonly Currency $currencyTo,
        private readonly float $commissionRate,
        private readonly float $currencyRate,
        private readonly string $orderType,
        private readonly \DateTime $createdAt,
        private readonly \DateTime $paidAt,
        private readonly User $createdBy,
    ) {
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Order
     */
    public function setAmount(float $amount): Order
    {
        $this->amount = $amount;
        return $this;
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
     * @return Order
     */
    public function setCurrencyFrom(Currency $currencyFrom): Order
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
     * @return Order
     */
    public function setCurrencyTo(Currency $currencyTo): Order
    {
        $this->currencyTo = $currencyTo;
        return $this;
    }

    /**
     * @return float
     */
    public function getCommissionRate(): float
    {
        return $this->commissionRate;
    }

    /**
     * @param float $commissionRate
     * @return Order
     */
    public function setCommissionRate(float $commissionRate): Order
    {
        $this->commissionRate = $commissionRate;
        return $this;
    }

    /**
     * @return float
     */
    public function getCurrencyRate(): float
    {
        return $this->currencyRate;
    }

    /**
     * @param float $currencyRate
     * @return Order
     */
    public function setCurrencyRate(float $currencyRate): Order
    {
        $this->currencyRate = $currencyRate;
        return $this;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     * @return Order
     */
    public function setOrderType(string $orderType): Order
    {
        $this->orderType = $orderType;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Order
     */
    public function setCreatedAt(\DateTime $createdAt): Order
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPaidAt(): \DateTime
    {
        return $this->paidAt;
    }

    /**
     * @param \DateTime $paidAt
     * @return Order
     */
    public function setPaidAt(\DateTime $paidAt): Order
    {
        $this->paidAt = $paidAt;
        return $this;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     * @return Order
     */
    public function setCreatedBy(User $createdBy): Order
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return float
     */
    public function getCommissionValue(): float
    {
        return $this->commissionValue;
    }

    /**
     * @param float $commissionValue
     * @return Order
     */
    public function setCommissionValue(float $commissionValue): Order
    {
        $this->commissionValue = $commissionValue;
        return $this;
    }

    /**
     * @return float
     */
    public function getWithdrawalAmount(): float
    {
        return $this->withdrawalAmount;
    }

    /**
     * @return Order
     */
    public function setWithdrawalAmount(): Order
    {
        $this->withdrawalAmount = $this->getAmount() * $this->getCurrencyRate();
        return $this;
    }
}
