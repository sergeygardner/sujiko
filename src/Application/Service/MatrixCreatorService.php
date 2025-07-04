<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Tool\PopulateTool;
use App\Domain\Collection\GroupDTOCollections;
use App\Domain\Collection\GroupIndexDTOCollections;
use App\Domain\Collection\MatrixDTOCollection;
use App\Domain\Collection\MatrixValueDTOCollection;
use App\Domain\Collection\MatrixValuesDTOCollection;

final readonly class MatrixCreatorService
{
    public function __construct(private PopulateTool $populateTool)
    {
    }

    public function createDullMatrix(
        int $maxNumber,
        GroupIndexDTOCollections $groupIndexDTOCollections,
        GroupDTOCollections $groupDTOCollections,
    ): MatrixDTOCollection {
        return $this->createMatrix(
            maxNumber: $maxNumber,
            matrixDTOCollections: new MatrixDTOCollection(),
            groupIndexDTOCollections: $groupIndexDTOCollections,
            groupDTOCollections: $groupDTOCollections,
            level: 0,
        );
    }

    private function createMatrix(
        int $maxNumber,
        MatrixDTOCollection $matrixDTOCollections,
        GroupIndexDTOCollections $groupIndexDTOCollections,
        GroupDTOCollections $groupDTOCollections,
        int $level,
    ): MatrixDTOCollection {
        $matrixDTOCollection = $matrixDTOCollections->get($level) ?? new MatrixValuesDTOCollection();
        $groupDTOCollection = $groupDTOCollections->get($level);
        $groupIndexDTOCollection = $groupIndexDTOCollections->get($level);

        if ($groupDTOCollection === null || $groupIndexDTOCollection === null) {
            return $matrixDTOCollections;
        }

        foreach ($groupDTOCollection as $groupDTO) {
            $populatedGroups = $this->populateTool->arguments($groupDTO);

            foreach ($populatedGroups as $populatedGroup) {
                $matrix = new MatrixValueDTOCollection();
                $index = -1;

                for ($i = 1; $i <= $maxNumber; $i++) {
                    if ($groupIndexDTOCollection->offsetExists($i)) {
                        $index++;
                        $matrix->set($i, $populatedGroup[$index]);
                    } else {
                        $matrix->set($i, 0);
                    }
                }

                $matrixDTOCollection->add($matrix);
            }
        }

        $matrixDTOCollections->set($level, $matrixDTOCollection);

        return $this->createMatrix(
            maxNumber: $maxNumber,
            matrixDTOCollections: $matrixDTOCollections,
            groupIndexDTOCollections: $groupIndexDTOCollections,
            groupDTOCollections: $groupDTOCollections,
            level: $level + 1,
        );
    }
}
