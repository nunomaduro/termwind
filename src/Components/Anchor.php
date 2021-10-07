<?php

declare(strict_types=1);

namespace Termwind\Components;

/**
 * @extends Element<string>
 */
final class Anchor extends Element
{
    /**
     * Sets the href property to the element.
     */
    public function href(string $href): self
    {
        return new self(
            $this->output,
            $this->state,
            array_merge($this->properties, [
                'href' => $href,
            ])
        );
    }
}
