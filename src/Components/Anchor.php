<?php

declare(strict_types=1);

namespace Termwind\Components;

final class Anchor extends Element
{
    /**
     * Sets the href property to the element.
     */
    public function href(string $href): self
    {
        return new self(
            $this->output,
            $this->value,
            array_merge($this->properties, [
                'href' => $href,
            ])
        );
    }
}
