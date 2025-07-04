<?php

namespace Tests\Unit\App\Infrastructure\Response;

use App\Infrastructure\Response\TableResponse;
use Console_Table;
use PHPUnit\Framework\TestCase;

class TableResponseTest extends TestCase
{
    public function testRender(): void
    {
        $table = new Console_Table();
        $actual = new TableResponse($table);

        $actual->render();

        self::expectOutputString(
            $table->getTable(),
        );
    }
}
