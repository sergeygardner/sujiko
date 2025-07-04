<?php

namespace App\Infrastructure\Service;

use App\Application\Service\FactoryService;
use App\Application\Service\InputCheckerService;
use App\Application\Service\MatrixCreatorService;
use App\Application\Service\ResolverService;
use App\Application\Tool\GaussSumTool;
use App\Application\Tool\PopulateTool;
use App\Domain\Collection\MatrixValuesDTOCollection;
use App\Infrastructure\Response\ResponseInterface;
use App\Infrastructure\Response\TableResponse;
use Console_Table;

class SimpleSolverContext extends AbstractContext
{
    private FactoryService $groupGetterService;

    private InputCheckerService $inputCheckerService;

    private MatrixCreatorService $matrixCreatorService;

    private ResolverService $resolverService;

    public function __construct(ConsoleOptionService $consoleOptionService)
    {
        parent::__construct($consoleOptionService);

        $this->groupGetterService = new FactoryService(
            gaussSumTool: new GaussSumTool(),
        );
        $this->inputCheckerService = new InputCheckerService(
            gaussSumTool: new GaussSumTool(),
        );
        $this->matrixCreatorService = new MatrixCreatorService(
            populateTool: new PopulateTool(),
        );
        $this->resolverService = new ResolverService();
    }

    public function solve(): ResponseInterface
    {
        $maxNumber = $this->consoleOptionService->getMaxNumber();
        $groupSum = $this->consoleOptionService->getGroupSum();
        $groups = $this->consoleOptionService->getGroups();
        $tuples = $this->consoleOptionService->getTuples();

        $this->inputCheckerService->checkSum(
            $maxNumber,
            ...$groupSum,
        );

        $groupDTOCollections = $this->groupGetterService->toGroupDTOCollections(
            $maxNumber,
            ...$groupSum,
        );

        $groupIndexDTOCollections = $this->groupGetterService->toGroupIndexDTOCollections(
            $maxNumber,
            $groups,
        );

        $tupleDTOCollections = $this->groupGetterService->toTupleDTOCollections(
            maxNumber: $maxNumber,
            tuples: $tuples,
        );

        $matrixCollection = $this->matrixCreatorService->createDullMatrix(
            maxNumber: $maxNumber,
            groupIndexDTOCollections: $groupIndexDTOCollections,
            groupDTOCollections: $groupDTOCollections,
        );

        $responseMatrixValuesCollection = $this->resolverService->resolve(
            matrixDTOCollections:  $matrixCollection,
            tupleDTOCollections:  $tupleDTOCollections,
        );

        return $this->prepareResponse($maxNumber, $responseMatrixValuesCollection);
    }

    private function prepareResponse(int $maxNumber, MatrixValuesDTOCollection $responseMatrixValuesCollection): ResponseInterface
    {
        $table = new Console_Table();
        $maxColumn =  pow($maxNumber, 1 / 2);

        foreach ($responseMatrixValuesCollection as $values) {
            $row = [];

            for ($i = 1; $i <= $maxNumber; $i++) {
                $row[] = $values->get($i);

                if ($i % $maxColumn === 0) {
                    $table->addRow($row);

                    $row = [];
                }
            }
        }

        return new TableResponse($table);
    }
}
