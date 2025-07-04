<?php

namespace Tests\Unit\App\Infrastructure\Service;

use App\Infrastructure\Bag\OptionsBag;
use App\Infrastructure\Service\AbstractContext;
use App\Infrastructure\Service\ConsoleOptionService;
use PHPUnit\Framework\TestCase;

class AbstractContextTest extends TestCase
{
    public function testIndex(): void
    {
        $systemUnderTest = new class (new ConsoleOptionService(new OptionsBag())) extends AbstractContext {
        };

        self::assertNotEmpty($systemUnderTest->index());
    }
}
