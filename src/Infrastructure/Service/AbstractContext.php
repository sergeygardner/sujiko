<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Infrastructure\Response\ResponseInterface;
use App\Infrastructure\Response\TextResponse;

/**
 *
 */
abstract class AbstractContext
{
    /**
     * @param ConsoleOptionService $consoleOptionService
     */
    public function __construct(protected readonly ConsoleOptionService $consoleOptionService)
    {
    }

    public function index(?ResponseInterface $response = null): ResponseInterface
    {
        return $response ?? new TextResponse(static::class);
    }
}
