<?php

namespace Tests\Unit\App\Infrastructure\Response;

use App\Infrastructure\Response\TextResponse;
use PHPUnit\Framework\TestCase;

class TextResponseTest extends TestCase
{
    public function testRender(): void
    {
        $actual = new TextResponse('test');

        $actual->render();

        self::expectOutputString(
            'test',
        );
    }
}
