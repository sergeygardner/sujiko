<?php

namespace Tests\Unit\App\Infrastructure\Service;

use App\Infrastructure\Bag\OptionsBag;
use App\Infrastructure\Response\TableResponse;
use App\Infrastructure\Service\ConsoleOptionService;
use App\Infrastructure\Service\SimpleSolverContext;
use Console_Table;
use Generator;
use PHPUnit\Framework\TestCase;

class SimpleSolverContextTest extends TestCase
{
    public static function data_provider(): Generator
    {
        $table = new Console_Table();
        $table->addRow([5, 8, 7]);
        $table->addRow([2, 4, 9]);
        $table->addRow([1, 3, 6]);

        $optionsBag = new OptionsBag();
        $optionsBag->maxNumber = [9];
        $optionsBag->groupSum = [[10, 8, 27]];
        $optionsBag->group = [1 => [3, 8], 2 => [1, 4, 7], 3 => [2, 5, 6, 9]];
        $optionsBag->tuple = [1 => [19], 2 => [28], 3 => [10], 4 => [22]];

        yield '9_10_8_27_3-8_1-4-7_2-5-6-9_19-28-10-22' => [
            'consoleOptionService' => new ConsoleOptionService(
                options: $optionsBag,
            ),
            'expected' => new TableResponse($table),
        ];
    }

    /**
     * @dataProvider data_provider
     */
    public function testSolve(
        ConsoleOptionService $consoleOptionService,
        TableResponse $expected,
    ): void {
        $simpleSolverContext = new SimpleSolverContext($consoleOptionService);

        self::assertEquals(
            $expected,
            $simpleSolverContext->solve(),
        );
    }
}
