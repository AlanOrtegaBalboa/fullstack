<?php

namespace App\Services\Frontend;

use App\Services\Frontend\UIElements\ResourceDetailLine;

use Exception;

final class ResourceDetailGenerator
{
    private array $lines = [];


    public function addLine(ResourceDetailLine $line): self
    {
        $this->lines[] = $line->generate();

        return $this;
    }

    public function getLines(): array
    {
        return $this->lines;
    }
}
