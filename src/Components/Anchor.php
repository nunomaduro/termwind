<?php

declare(strict_types=1);

namespace Termwind\Components;

final class Anchor extends Element
{
    /**
     * Sets the href property to the element.
     */
    final public function href(string $href): self
    {
        return $this->with(['href' => [$href]]);
    }
}
