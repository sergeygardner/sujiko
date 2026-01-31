<?php

namespace Tests\Unit\App\Infrastructure\Bag;

use App\Domain\Exception\WrongArgumentTypeDomainException;
use App\Infrastructure\Bag\OptionsBag;
use Generator;
use PHPUnit\Framework\TestCase;

class OptionsBagTest extends TestCase
{
    public static function dataProvider(): Generator
    {
        yield OptionsBag::MAX_NUMBER => [
            'fieldName' => OptionsBag::MAX_NUMBER,
            'iterator' => 0,
            'value' => 1,
            'expected' => [1],
        ];
        yield OptionsBag::GROUP_SUM => [
            'fieldName' => OptionsBag::GROUP_SUM,
            'iterator' => 0,
            'value' => 1,
            'expected' => [[1]],
        ];
        yield OptionsBag::GROUP => [
            'fieldName' => OptionsBag::GROUP,
            'iterator' => 0,
            'value' => 1,
            'expected' => [[1]],
        ];
        yield OptionsBag::TUPLE => [
            'fieldName' => OptionsBag::TUPLE,
            'iterator' => 0,
            'value' => 1,
            'expected' => [[1]],
        ];
        yield 'wrong field' => [
            'fieldName' => 'fieldName',
            'iterator' => 0,
            'value' => null,
            'expected' => null,
            'exception' => WrongArgumentTypeDomainException::class,
        ];
        yield 'wrong value' => [
            'fieldName' => OptionsBag::TUPLE,
            'iterator' => 0,
            'value' => null,
            'expected' => null,
            'exception' => WrongArgumentTypeDomainException::class,
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSetValue(
        string $fieldName,
        int $iterator,
        ?int $value,
        ?array $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        $optionsBag = new OptionsBag();
        $optionsBag->setValue($fieldName, $iterator, $value);

        self::assertEquals($expected, $optionsBag->{$fieldName});
    }
}
