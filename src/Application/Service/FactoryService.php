<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Tool\GaussSumTool;
use App\Domain\Collection\GroupDTOCollection;
use App\Domain\Collection\GroupDTOCollections;
use App\Domain\Collection\GroupIndexDTOCollection;
use App\Domain\Collection\GroupIndexDTOCollections;
use App\Domain\Collection\TupleDTOCollection;
use App\Domain\Collection\TupleDTOCollections;
use App\Domain\Exception\WrongGroupIndexesDomainException;
use App\Domain\Exception\WrongTuplesDomainException;

/**
 *
 */
final readonly class FactoryService
{
    /**
     * @param GaussSumTool $gaussSumTool
     */
    public function __construct(private GaussSumTool $gaussSumTool)
    {
    }

    /**
     * @param int $maxNumber
     * @param int ...$groupsSum
     *
     * @return GroupDTOCollections
     */
    public function toGroupDTOCollections(
        int $maxNumber,
        int ...$groupsSum,
    ): GroupDTOCollections {
        return $this->createDTOCollection(
            groupDTOCollection: new GroupDTOCollections(),
            maxNumber: $maxNumber,
            groupsSum: $groupsSum,
            current: [],
            level: -1,
        );
    }

    /**
     * @param int $maxNumber
     * @param array<int, array<int, int>> $groups
     *
     * @return GroupIndexDTOCollections
     */
    public function toGroupIndexDTOCollections(int $maxNumber, array $groups): GroupIndexDTOCollections
    {
        if ($this->gaussSumTool->getSum($maxNumber) !== array_sum(array_merge(...$groups))) {
            throw new WrongGroupIndexesDomainException();
        }

        $groupDTOCollection = new GroupIndexDTOCollections();

        foreach ($groups as $group) {
            $groupDTOCollection->add(new GroupIndexDTOCollection(array_combine($group, $group)));
        }

        return $groupDTOCollection;
    }


    /**
     * @param int $maxNumber
     * @param array<int, array<int, int>> $tuples
     *
     * @return TupleDTOCollections
     */
    public function toTupleDTOCollections(int $maxNumber, array $tuples): TupleDTOCollections
    {
        $tupleDTOCollection = new TupleDTOCollections();
        $columnCount = (int) pow($maxNumber, 1 / 2);
        $columnTupleCount = (int) ceil($columnCount / 2);
        $checkedSumTuples = (int) ($columnTupleCount * (($maxNumber / $columnCount) - 1));

        if (count($tuples) !== $checkedSumTuples) {
            throw new WrongTuplesDomainException();
        }

        $shift = 0;

        foreach ($tuples as $key => $tuple) {
            if (count($tuple) > 1) {
                throw new WrongTuplesDomainException();
            }

            $i = $key + $shift;

            if (($i + 1) % $columnCount === 0) {
                $shift++;
            }

            $tupleCollection = new TupleDTOCollection(
                [
                    $i,
                    $i + 1,
                    $i + $columnCount,
                    $i + $columnCount + 1,
                ],
            );

            $tupleCollection->sum = $tuple[0];

            $tupleDTOCollection->add($tupleCollection);
        }

        return $tupleDTOCollection;
    }

    /**
     * @param GroupDTOCollections $groupDTOCollection
     * @param int $maxNumber
     * @param array<int|string, int> $groupsSum
     * @param array<int, int> $current
     * @param int $level
     *
     * @return GroupDTOCollections
     */
    private function createDTOCollection(
        GroupDTOCollections $groupDTOCollection,
        int $maxNumber,
        array $groupsSum,
        array $current,
        int $level,
    ): GroupDTOCollections {
        if ($level > -1 && ! isset($groupsSum[$level])) {
            return $groupDTOCollection;
        }

        if ($level > -1 && ! $groupDTOCollection->containsKey($level)) {
            $groupDTOCollection->set($level, new GroupDTOCollection());
        }

        $start = ($current[$level] ?? 0) + 1;

        for ($i = $start; $i <= $maxNumber; $i++) {
            if ($level > -1) {
                if ($groupsSum[$level] === array_sum($current) + $i) {
                    $currentGroupDTOCollection = $groupDTOCollection->get($level);

                    if ($currentGroupDTOCollection instanceof GroupDTOCollection) {
                        $currentGroupDTOCollection->add(
                            [
                                ...$current,
                                $i,
                            ],
                        );
                        $groupDTOCollection->set(
                            $level,
                            $currentGroupDTOCollection,
                        );
                    }
                }
            }

            $groupDTOCollection = $this->createDTOCollection(
                groupDTOCollection: $groupDTOCollection,
                maxNumber: $maxNumber,
                groupsSum: $groupsSum,
                current: [
                    ...$current,
                    $i,
                ],
                level: $level + 1,
            );
        }

        return $groupDTOCollection;
    }
}
