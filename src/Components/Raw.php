<?php

declare(strict_types=1);

namespace Termwind\Components;

/**
 * @internal
 */
final class Raw extends Element
{
    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->content;
    }
}
