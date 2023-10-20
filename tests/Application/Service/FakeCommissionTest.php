<?php

declare(strict_types=1);

namespace Test\Application\Service;

use MiniCurrencyExchange\Application\Service\FakeCommission;
use MiniCurrencyExchange\Domain\Entity\Commission;
use PHPUnit\Framework\TestCase;

final class FakeCommissionTest extends TestCase
{
    /**
     * @var FakeCommission
     */
    private FakeCommission $testClass;

    public function setUp(): void
    {
        $this->testClass = new FakeCommission();
    }

    /**
     * @dataProvider makeFakeCommissionDataProvider
     * @param int $expectedId
     * @param string $expectedName
     * @param int $expectedValue
     */
    public function testMakeFakeCommission(
        int $expectedId,
        string $expectedName,
        int $expectedValue
    ): void {
        $this->testClass->makeFakeCommission();
        /** @var array<Commission> $commissions */
        $commissions = $this->testClass->getCommissions();

        $this->assertCount(1, $commissions);
        $this->assertSame($expectedId, $commissions[0]->getId());
        $this->assertSame($expectedName, $commissions[0]->getName());
        $this->assertSame($expectedValue, $commissions[0]->getPercentageValue());
    }

    public static function makeFakeCommissionDataProvider(): array
    {
        $testObject = new Commission(1, FakeCommission::NAME, FakeCommission::VALUE);

        return [
            [
                $testObject->getId(),
                $testObject->getName(),
                $testObject->getPercentageValue()
            ]
        ];
    }

    public function testEmptyCommissions(): void
    {
        $fakeCommission = new FakeCommission();

        $this->assertEmpty($fakeCommission->getCommissions());
    }
}
