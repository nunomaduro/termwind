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
        // Ignore empty links
        if ($href === '') {
            return $this;
        }

        return $this->with(['options' => ['href' => $href]]);
    }
}
