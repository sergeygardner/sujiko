<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Service;

use App\Application\Service\ResolverService;
use App\Domain\Collection\MatrixDTOCollection;
use App\Domain\Collection\MatrixValueDTOCollection;
use App\Domain\Collection\MatrixValuesDTOCollection;
use App\Domain\Collection\TupleDTOCollection;
use App\Domain\Collection\TupleDTOCollections;
use Generator;
use PHPUnit\Framework\TestCase;

class ResolverServiceTest extends TestCase
{
    private ?ResolverService $resolverService = null;

    public static function dataProvider(): Generator
    {
        $tuple1 = new TupleDTOCollection(
            [1, 2, 4, 5],
        );
        $tuple1->sum = 20;
        $tuple2 = new TupleDTOCollection(
            [2, 3, 5, 6],
        );
        $tuple2->sum = 18;
        $tuple3 = new TupleDTOCollection(
            [4, 5, 7, 8],
        );
        $tuple3->sum = 27;
        $tuple4 = new TupleDTOCollection(
            [5, 6, 8, 9],
        );
        $tuple4->sum = 26;

        yield '_' => [
            'matrixDTOCollections' => new MatrixDTOCollection(
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
                                [1 => 0, 2 => 0, 3 => 1, 4 => 7, 5 => 9, 6 => 0, 7 => 0, 8 => 0, 9 => 0],
                            ),
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
                        ],
                    ),
                ],
            ),
            'tupleDTOCollections' => new TupleDTOCollections(
                [
                    $tuple1,
                    $tuple2,
                    $tuple3,
                    $tuple4,
                ],
            ),
            'expected' => new MatrixValuesDTOCollection(
                [
                    new MatrixValueDTOCollection(
                        [1 => 1, 2 => 3, 3 => 2, 4 => 7, 5 => 9, 6 => 4, 7 => 6, 8 => 5, 9 => 8],
                    ),
                ],
            ),
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCheckSum(
        MatrixDTOCollection $matrixDTOCollections,
        TupleDTOCollections $tupleDTOCollections,
        MatrixValuesDTOCollection $expected,
    ): void {
        $actual = $this->resolverService->resolve(
            $matrixDTOCollections,
            $tupleDTOCollections,
        );

        foreach ($actual as $matrix) {
            self::assertEquals(
                $expected->current()->toArray(),
                $matrix->toArray(),
            );
        }
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->resolverService = new ResolverService();
    }
}
