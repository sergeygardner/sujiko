<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Service;

use App\Application\Service\MatrixCreatorService;
use App\Application\Tool\PopulateTool;
use App\Domain\Collection\GroupDTOCollection;
use App\Domain\Collection\GroupDTOCollections;
use App\Domain\Collection\GroupIndexDTOCollection;
use App\Domain\Collection\GroupIndexDTOCollections;
use App\Domain\Collection\MatrixDTOCollection;
use App\Domain\Collection\MatrixValueDTOCollection;
use App\Domain\Collection\MatrixValuesDTOCollection;
use Generator;
use PHPUnit\Framework\TestCase;

class MatrixCreatorServiceTest extends TestCase
{
    private ?MatrixCreatorService $matrixCreatorService = null;

    public static function dataProvider(): Generator
    {
        yield '9' => [
            'maxNumber' => 9,
            'groupIndexDTOCollections' => new GroupIndexDTOCollections(
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
            'groupDTOCollections' => new GroupDTOCollections(
                [
                    new GroupDTOCollection(
                        [[1, 3]],
                    ),
                    new GroupDTOCollection(
                        [
                            [2, 7, 9],
                        ],
                    ),
                    new GroupDTOCollection(
                        [
                            [4, 5, 6, 8],
                        ],
                    ),
                ],
            ),
            'expected' => new MatrixDTOCollection(
                [
                    new MatrixValuesDTOCollection(
                        [
                            new MatrixValueDTOCollection(
                                [1 => 1, 2 => 3, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 3, 2 => 1, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                        ],
                    ),
                    new MatrixValuesDTOCollection(
                        [
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 2, 4 => 7, 5 => 9, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 2, 4 => 9, 5 => 7, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 7, 4 => 2, 5 => 9, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 7, 4 => 9, 5 => 2, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 9, 4 => 2, 5 => 7, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 9, 4 => 7, 5 => 2, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
                        ],
                    ),
                    new MatrixValuesDTOCollection(
                        [
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 5, 8 => 6, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 5, 8 => 8, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 6, 8 => 5, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 6, 8 => 8, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 8, 8 => 5, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 4, 7 => 8, 8 => 6, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 4, 8 => 6, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 4, 8 => 8, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 6, 8 => 4, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 6, 8 => 8, 9 => 4],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 8, 8 => 4, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 5, 7 => 8, 8 => 6, 9 => 4],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 4, 8 => 5, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 4, 8 => 8, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 5, 8 => 4, 9 => 8],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 5, 8 => 8, 9 => 4],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 8, 8 => 4, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 6, 7 => 8, 8 => 5, 9 => 4],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 4, 8 => 5, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 4, 8 => 6, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 5, 8 => 4, 9 => 6],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 5, 8 => 6, 9 => 4],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 6, 8 => 4, 9 => 5],
                            ),
                            new MatrixValueDTOCollection(
                                [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 8, 7 => 6, 8 => 5, 9 => 4],
                            ),
                        ]
                    ),
                ],
            ),
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCreateDullMatrix(
        int $maxNumber,
        GroupIndexDTOCollections $groupIndexDTOCollections,
        GroupDTOCollections $groupDTOCollections,
        MatrixDTOCollection $expected,
    ): void {
        $actual = $this->matrixCreatorService->createDullMatrix(
            maxNumber: $maxNumber,
            groupIndexDTOCollections: $groupIndexDTOCollections,
            groupDTOCollections: $groupDTOCollections,
        );

        foreach ($actual as $actualMatrixValuesIndex => $actualMatrixValues) {
            foreach ($actualMatrixValues as $actualMatrixValueIndex => $actualMatrixValue) {
                self::assertEquals(
                    $expected->get($actualMatrixValuesIndex)->get($actualMatrixValueIndex)?->toArray(),
                    $actualMatrixValue->toArray(),
                    sprintf(
                        '$actualMatrixValuesIndex(%s) $actualMatrixValueIndex(%s)',
                        $actualMatrixValuesIndex,
                        $actualMatrixValueIndex,
                    ),
                );
            }
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->matrixCreatorService = new MatrixCreatorService(populateTool: new PopulateTool());
    }
}
