<?php

declare(strict_types=1);

namespace Termwind\Components;

final class BreakLine extends Element
{
    /**
     * Get the string representation of the element.
     */
    public function toString(): string
    {
        return parent::toString()."\n";
    }
}
