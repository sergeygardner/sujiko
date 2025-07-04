<?php

namespace App\Infrastructure\Response;

final readonly class TextResponse implements ResponseInterface
{
    public function __construct(private string $text)
    {
    }

    public function render(): void
    {
        echo $this->text;
    }
}
