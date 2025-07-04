<?php

namespace App\Infrastructure\Response;

use Console_Table;

final readonly class TableResponse implements ResponseInterface
{
    public function __construct(private Console_Table $table)
    {
    }

    public function render(): void
    {
        echo $this->table->getTable();
    }
}
