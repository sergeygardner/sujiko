<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Tool;

use App\Application\Tool\PopulateTool;
use Generator;
use PHPUnit\Framework\TestCase;

class PopulateToolTest extends TestCase
{
    private ?PopulateTool $populateTool = null;

    public static function data_provider(): Generator
    {
        yield '1_2' => [
            'arguments' => [1, 2],
            'expected' => [[1, 2], [2, 1]],
            'exception' => null,
        ];
        yield '1_2_3' => [
            'arguments' => [1, 2, 3],
            'expected' => [[1, 2, 3], [1, 3, 2], [2, 1, 3], [2, 3, 1], [3, 1, 2], [3, 2, 1]],
            'exception' => null,
        ];
        yield '1_2_3_4' => [
            'arguments' => [1, 2, 3, 4],
            'expected' => [
                [1, 2, 3, 4],
                [1, 2, 4, 3],
                [1, 3, 2, 4],
                [1, 3, 4, 2],
                [1, 4, 2, 3],
                [1, 4, 3, 2],
                [2, 1, 3, 4],
                [2, 1, 4, 3],
                [2, 3, 1, 4],
                [2, 3, 4, 1],
                [2, 4, 1, 3],
                [2, 4, 3, 1],
                [3, 1, 2, 4],
                [3, 1, 4, 2],
                [3, 2, 1, 4],
                [3, 2, 4, 1],
                [3, 4, 1, 2],
                [3, 4, 2, 1],
                [4, 1, 2, 3],
                [4, 1, 3, 2],
                [4, 2, 1, 3],
                [4, 2, 3, 1],
                [4, 3, 1, 2],
                [4, 3, 2, 1],
            ],
            'exception' => null,
        ];
    }

    /**
     * @dataProvider data_provider
     */
    public function testToGroupDTOCollection(
        array $arguments,
        array $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertEquals(
            $expected,
            $this->populateTool->arguments($arguments),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->populateTool = new PopulateTool();
    }
}
