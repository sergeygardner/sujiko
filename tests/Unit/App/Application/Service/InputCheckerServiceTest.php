<?php

declare(strict_types=1);

namespace Tests\Unit\App\Application\Service;

use App\Application\Service\InputCheckerService;
use App\Application\Tool\GaussSumTool;
use App\Domain\Exception\WrongGroupSumDomainException;
use Generator;
use PHPUnit\Framework\TestCase;

class InputCheckerServiceTest extends TestCase
{
    private ?InputCheckerService $inputCheckerService = null;

    public static function data_provider(): Generator
    {

        yield '9_10-8-27' => [
            'maxNumber' => 9,
            'groupSums' => [10, 8, 27],
            'exception' => null,
        ];
        yield '9_10-8-26' => [
            'maxNumber' => 9,
            'groupSums' => [10, 8, 26],
            'exception' => WrongGroupSumDomainException::class,
        ];
    }

    /**
     * @dataProvider data_provider
     */
    public function testCheckSum(
        int $maxNumber,
        array $groupSums,
        ?string $exception = null,
    ): void {
        $nullIsNull = null;

        if (null !== $exception) {
            $this->expectException($exception);

            $nullIsNull = INF;
        }

        $this->inputCheckerService->checkSum($maxNumber, ...$groupSums);

        self::assertNull($nullIsNull);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->inputCheckerService = new InputCheckerService(gaussSumTool: new GaussSumTool());
    }
}
