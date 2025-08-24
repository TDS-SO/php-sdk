<?php

declare(strict_types=1);

namespace TdsSo\Sdk\Tests\Unit\Builders;

use TdsSo\Sdk\Builders\TemplateBuilder;
use TdsSo\Sdk\Tests\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
final class TemplateBuilderTest extends TestCase
{
    private $builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->builder = new TemplateBuilder();
    }

    public function testSetName(): void
    {
        $result = $this->builder->setName('Test Template');

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('setting_name', $this->builder->toArray());
        self::assertSame('Test Template', $this->builder->toArray()['setting_name']);
    }


    public function testSetRedirectType(): void
    {
        $result = $this->builder->setRedirectType('301');

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('redirect_type', $this->builder->toArray());
        self::assertSame('301', $this->builder->toArray()['redirect_type']);
    }

    public function testSetRedirectDelay(): void
    {
        $result = $this->builder->setRedirectDelay(5);

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('redirect_delay', $this->builder->toArray());
        self::assertSame(5, $this->builder->toArray()['redirect_delay']);
    }

    public function testSetBanCheck(): void
    {
        $result = $this->builder->setBanCheck(true);

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('is_ban_check', $this->builder->toArray());
        self::assertTrue($this->builder->toArray()['is_ban_check']);
    }

    public function testSetRandomPhrases(): void
    {
        $result = $this->builder->setRandomPhrases(true);

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('is_random_phraze', $this->builder->toArray());
        self::assertTrue($this->builder->toArray()['is_random_phraze']);
    }

    public function testSetMinSymbols(): void
    {
        $result = $this->builder->setMinSymbols(3);

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('min_symbols', $this->builder->toArray());
        self::assertSame(3, $this->builder->toArray()['min_symbols']);
    }

    public function testSetMaxSymbols(): void
    {
        $result = $this->builder->setMaxSymbols(15);

        self::assertSame($this->builder, $result);
        self::assertArrayHasKey('max_symbols', $this->builder->toArray());
        self::assertSame(15, $this->builder->toArray()['max_symbols']);
    }

    public function testChainedMethods(): void
    {
        $data = $this->builder
            ->setName('Chained Template')
            ->setRedirectType('302')
            ->setRedirectDelay(10)
            ->setBanCheck(false)
            ->setRandomPhrases(true)
            ->setMinSymbols(5)
            ->setMaxSymbols(20)
            ->toArray()
        ;

        $expected = [
            'setting_name'      => 'Chained Template',
            'redirect_type'     => '302',
            'redirect_delay'    => 10,
            'is_ban_check'      => false,
            'is_random_phraze'  => true,
            'min_symbols'       => 5,
            'max_symbols'       => 20,
        ];

        self::assertSame($expected, $data);
    }

    public function testToArrayWithPartialData(): void
    {
        $data = $this->builder
            ->setName('Partial Template')
            ->setRedirectType('301')
            ->toArray()
        ;

        self::assertArrayHasKey('setting_name', $data);
        self::assertArrayHasKey('redirect_type', $data);
        self::assertCount(2, $data);
    }
}
