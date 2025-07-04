<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Service;

use App\Application\Service\FactoryService;
use App\Application\Tool\GaussSumTool;
use App\Domain\Collection\GroupDTOCollection;
use App\Domain\Collection\GroupDTOCollections;
use App\Domain\Collection\GroupIndexDTOCollection;
use App\Domain\Collection\GroupIndexDTOCollections;
use App\Domain\Collection\TupleDTOCollection;
use App\Domain\Collection\TupleDTOCollections;
use App\Domain\Exception\WrongGroupIndexesDomainException;
use App\Domain\Exception\WrongTuplesDomainException;
use Generator;
use PHPUnit\Framework\TestCase;

class FactoryServiceTest extends TestCase
{
    private ?FactoryService $groupGetterService = null;

    public static function group_data_provider(): Generator
    {
        yield '9_4-18-23_24-29-14-19' => [
            'maxNumber' => 9,
            'groupsSum' => [4, 18, 23],
            'expected' => new GroupDTOCollections(
                [
                    new GroupDTOCollection(
                        [[1, 3]],
                    ),
                    new GroupDTOCollection(
                        [
                            [1, 8, 9],
                            [2, 7, 9],
                            [3, 6, 9],
                            [3, 7, 8],
                            [4, 5, 9],
                            [4, 6, 8],
                            [5, 6, 7],
                        ],
                    ),
                    new GroupDTOCollection(
                        [
                            [1, 5, 8, 9],
                            [1, 6, 7, 9],
                            [2, 4, 8, 9],
                            [2, 5, 7, 9],
                            [2, 6, 7, 8],
                            [3, 4, 7, 9],
                            [3, 5, 6, 9],
                            [3, 5, 7, 8],
                            [4, 5, 6, 8],

                        ],
                    ),
                ],
            ),
            'exception' => null,
        ];
    }


    public static function group_index_data_provider(): Generator
    {
        yield '9_1-2_3-4-5_6-7-8-9' => [
            'maxNumber' => 9,
            'groups' => [1 => [1, 2], 2 => [3, 4, 5], 3 => [6, 7, 8, 9]],
            'expected' => new GroupIndexDTOCollections(
                [
                    new GroupIndexDTOCollection(
                        [1 => 1, 2 => 2],
                    ),
                    new GroupIndexDTOCollection(
                        [3 => 3, 4 => 4, 5 => 5],
                    ),
                    new GroupIndexDTOCollection(
                        [6 => 6, 7 => 7, 8 => 8, 9 => 9],
                    ),
                ],
            ),
            'exception' => null,
        ];
        yield '9_1-2_3-4-5_6-7-8' => [
            'maxNumber' => 9,
            'groups' => [1 => [1, 2], 2 => [3, 4, 5], 3 => [6, 7, 8]],
            'expected' => new GroupIndexDTOCollections(),
            'exception' => WrongGroupIndexesDomainException::class,
        ];
    }

    public static function tuple_data_provider(): Generator
    {
        $tuple1 = new TupleDTOCollection(
            [1, 2, 4, 5],
        );
        $tuple1->sum = 24;
        $tuple2 = new TupleDTOCollection(
            [2, 3, 5, 6],
        );
        $tuple2->sum = 29;
        $tuple3 = new TupleDTOCollection(
            [4, 5, 7, 8],
        );
        $tuple3->sum = 14;
        $tuple4 = new TupleDTOCollection(
            [5, 6, 8, 9],
        );
        $tuple4->sum = 19;
        yield '9_24-29-14-19' => [
            'maxNumber' => 9,
            'tuples' => [1 => [24], 2 => [29], 3 => [14], 4 => [19]],
            'expected' => new TupleDTOCollections(
                [
                    $tuple1,
                    $tuple2,
                    $tuple3,
                    $tuple4,
                ],
            ),
            'exception' => null,
        ];
        yield '9_24-29-14' => [
            'maxNumber' => 9,
            'tuples' => [1 => [24], 2 => [29], 3 => [14]],
            'expected' => new TupleDTOCollections(
                [
                    $tuple1,
                    $tuple2,
                    $tuple3,
                ],
            ),
            'exception' => WrongTuplesDomainException::class,
        ];
        yield '9_24-24-29-14-19' => [
            'maxNumber' => 9,
            'tuples' => [1 => [24, 24], 2 => [29], 3 => [14], 4 => [19]],
            'expected' => new TupleDTOCollections(
                [
                    $tuple1,
                    $tuple2,
                    $tuple3,
                ],
            ),
            'exception' => WrongTuplesDomainException::class,
        ];
    }

    /**
     * @dataProvider group_data_provider
     */
    public function testToGroupDTOCollection(
        int $maxNumber,
        array $groupsSum,
        GroupDTOCollections $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertEquals(
            $expected,
            $this->groupGetterService->toGroupDTOCollections($maxNumber, ...$groupsSum),
        );
    }

    /**
     * @dataProvider group_index_data_provider
     */
    public function testToGroupIndexDTOCollections(
        int $maxNumber,
        array $groups,
        GroupIndexDTOCollections $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertEquals(
            $expected,
            $this->groupGetterService->toGroupIndexDTOCollections($maxNumber, $groups),
        );
    }

    /**
     * @dataProvider tuple_data_provider
     */
    public function testToTupleDTOCollections(
        int $maxNumber,
        array $tuples,
        TupleDTOCollections $expected,
        ?string $exception = null,
    ): void {
        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertEquals(
            $expected,
            $this->groupGetterService->toTupleDTOCollections($maxNumber, $tuples),
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->groupGetterService = new FactoryService(gaussSumTool: new GaussSumTool());
    }
}
