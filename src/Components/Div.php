<?php

declare(strict_types=1);

namespace Termwind\Components;

final class Div extends Element
{
    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return parent::toString().\PHP_EOL;
    }
}
