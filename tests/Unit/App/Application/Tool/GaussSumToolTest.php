<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Tool;

use App\Application\Tool\GaussSumTool;
use Generator;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

class GaussSumToolTest extends TestCase
{
    private ?GaussSumTool $gaussSumTool = null;

    public static function dataProvider(): Generator
    {
        yield '9' => [
            'number' => 9,
            'expected' => 45,
            'exception' => null,
        ];
        yield '8' => [
            'number' => 8,
            'expected' => 45,
            'exception' => AssertionFailedError::class,
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testToGroupDTOCollection(
        int $number,
        int $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertEquals(
            $expected,
            $this->gaussSumTool->getSum($number),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->gaussSumTool = new GaussSumTool();
    }
}
