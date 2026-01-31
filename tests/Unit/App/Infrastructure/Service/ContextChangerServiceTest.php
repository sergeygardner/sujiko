<?php

namespace Tests\Unit\App\Infrastructure\Service;

use App\Infrastructure\Service\ContextChangerService;
use App\Infrastructure\Service\SimpleSolverContext;
use Console_Table;
use Generator;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class ContextChangerServiceTest extends TestCase
{
    public static function dataProvider(): Generator
    {
        $table = new Console_Table();
        $table->addRow([5, 8, 7]);
        $table->addRow([2, 4, 9]);
        $table->addRow([1, 3, 6]);

        yield 'simple:solver:solve_9_10_8_27_3-8_1-4-7_2-5-6-9_19-28-10-22' => [
            'argv' => [
                "./bin/sujiko",
                "simple:solver:solve",
                "--maxNumber=9",
                "--groupSum=10",
                "--groupSum=8",
                "--groupSum=27",
                "--group1=3",
                "--group1=8",
                "--group2=1",
                "--group2=4",
                "--group2=7",
                "--group3=2",
                "--group3=5",
                "--group3=6",
                "--group3=9",
                "--tuple1=19",
                "--tuple2=28",
                "--tuple3=10",
                "--tuple4=22",
            ],
            'expected' => $table->getTable(),
        ];

        yield 'simple:solver:index' => [
            'argv' => [
                "./bin/sujiko",
                "simple:solver:index",
            ],
            'expected' => SimpleSolverContext::class,
        ];

        yield 'simple:solver:index_wrong_option' => [
            'argv' => [
                "./bin/sujiko",
                "simple:solver:index",
                "--test=test",
            ],
            'expected' => '',
            'exception' => RuntimeException::class,
        ];

        yield 'simple:solver1:index' => [
            'argv' => [
                "./bin/sujiko",
                "simple:solver1:index",
            ],
            'expected' => '',
            'exception' => RuntimeException::class,
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testSwitch(
        array $argv,
        string $expected,
        ?string $exception = null,
    ): void {
        if ($exception) {
            $this->expectException($exception);
        }

        $systemUnderTest = new ContextChangerService($argv);

        $systemUnderTest->switch();

        $this->expectOutputString($expected);
    }
}
