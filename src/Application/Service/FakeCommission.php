<?php

declare(strict_types=1);

namespace MiniCurrencyExchange\Application\Service;

use MiniCurrencyExchange\Infrastructure\Factory\CommissionFactory;

final class FakeCommission
{
    public const NAME = 'THE ONE';
    public const VALUE = 1;

    public function __construct(
        private array $commissions = []
    ) {
    }

    public function makeFakeCommission(): void
    {
        $this->commissions[] = CommissionFactory::create([1, self::NAME, self::VALUE]);
    }

    /**
     * @return array
     */
    public function getCommissions(): array
    {
        return $this->commissions;
    }
}
