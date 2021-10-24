<?php

declare(strict_types=1);

namespace Termwind\Components;

/**
 * @internal
 */
final class Raw extends Element
{
    /**
     * Get the string representation of the element.
     */
    public function toString(): string
    {
        return $this->content;
    }
}
