<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

/**
 *
 */
interface ContextChangerServiceInterface
{
    /**
     * @return void
     */
    public function switch(): void;
}
