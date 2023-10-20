<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Domain\Entity;

final class Order extends AbstractEntity
{
    public const BUY_TYPE = 'buy';  //todo move these types to separate OrderType entity & repo
    public const SELL_TYPE = 'sell';

    /**
     * @var float
     */
    private float $commissionValue = 0.0;

    /**
     * @var float
     */
    private float $withdrawalAmount = 0.0;

    public function __construct(
        int $id,
        private float $amount,
        private Currency $currencyFrom,
        private Currency $currencyTo,
        private float $commissionRate,
        private float $currencyRate,
        private string $orderType,
        private \DateTime $createdAt,
        private \DateTime $paidAt,
        private User $createdBy,
    ) {
        parent::__construct($id);
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
     * @param float $withdrawalAmount
     * @return Order
     */
    public function setWithdrawalAmount(float $withdrawalAmount): Order
    {
        $this->withdrawalAmount = $withdrawalAmount;
        return $this;
    }
}
