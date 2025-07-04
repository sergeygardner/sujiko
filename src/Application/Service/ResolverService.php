<?php

namespace App\Application\Service;

use App\Domain\Collection\MatrixDTOCollection;
use App\Domain\Collection\MatrixValueDTOCollection;
use App\Domain\Collection\MatrixValuesDTOCollection;
use App\Domain\Collection\TupleDTOCollections;

final readonly class ResolverService
{
    public function resolve(
        MatrixDTOCollection $matrixDTOCollections,
        TupleDTOCollections $tupleDTOCollections,
    ): MatrixValuesDTOCollection {
        $level = 0;

        return $this->find(
            level: $level,
            responseValuesDTOCollection: new MatrixValuesDTOCollection(),
            targetMatrixDTOCollections: new MatrixValuesDTOCollection(),
            sourceMatrixDTOCollections: $matrixDTOCollections,
            tupleDTOCollections: $tupleDTOCollections,
        );
    }

    private function find(
        int $level,
        MatrixValuesDTOCollection $responseValuesDTOCollection,
        MatrixValuesDTOCollection $targetMatrixDTOCollections,
        MatrixDTOCollection $sourceMatrixDTOCollections,
        TupleDTOCollections $tupleDTOCollections,
    ): MatrixValuesDTOCollection {
        foreach ($sourceMatrixDTOCollections->get($level) ?? [] as $matrixValueDTOCollection) {
            $targetMatrixDTOCollections->set($level, $matrixValueDTOCollection);

            if ($sourceMatrixDTOCollections->offsetExists($level + 1)) {
                $responseValuesDTOCollection = $this->find(
                    level: $level + 1,
                    responseValuesDTOCollection: $responseValuesDTOCollection,
                    targetMatrixDTOCollections: $targetMatrixDTOCollections,
                    sourceMatrixDTOCollections: $sourceMatrixDTOCollections,
                    tupleDTOCollections: $tupleDTOCollections,
                );
            } else {
                $resultDTOCollection = $this->prepareResultValues(
                    targetMatrixDTOCollections: $targetMatrixDTOCollections,
                );

                if ($resultDTOCollection !== null) {
                    $resultDTOCollection = $this->checkTupleSum(
                        tupleDTOCollections: $tupleDTOCollections,
                        resultDTOCollection: $resultDTOCollection,
                    );

                    if ($resultDTOCollection !== null) {
                        $responseValuesDTOCollection->add($resultDTOCollection);
                    }
                }
            }
        }

        return $responseValuesDTOCollection;
    }

    private function prepareResultValues(
        MatrixValuesDTOCollection $targetMatrixDTOCollections,
    ): ?MatrixValueDTOCollection {
        $resultDTOCollection = new MatrixValueDTOCollection();

        foreach ($targetMatrixDTOCollections as $targetMatrixValueDTOCollection) {
            foreach ($targetMatrixValueDTOCollection as $key => $value) {
                if ($value > 0) {
                    if ($resultDTOCollection->hasValue($value)) {
                        return null;
                    }

                    $resultDTOCollection->set($key, $value);
                }
            }
        }

        return $resultDTOCollection;
    }

    private function checkTupleSum(
        TupleDTOCollections $tupleDTOCollections,
        MatrixValueDTOCollection $resultDTOCollection
    ): ?MatrixValueDTOCollection {
        foreach ($tupleDTOCollections as $tupleDTOCollection) {
            $sum = 0;

            foreach ($tupleDTOCollection as $key) {
                if ($resultDTOCollection->offsetExists($key)) {
                    $sum += $resultDTOCollection->get($key);
                }
            }

            if ($sum !== $tupleDTOCollection->sum) {
                return null;
            }
        }

        return $resultDTOCollection;
    }
}
