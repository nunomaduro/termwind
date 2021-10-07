<?php

declare(strict_types=1);

namespace Termwind\Components;

use Termwind\Contracts\Renderable;

/**
 * @extends Element<array<int, Renderable>>
 */
final class Div extends Element
{
    /**
     * Get the string representation of the element.
     */
    public function toString(): string
    {
        $state = implode('', array_map(
            fn ($element) => (string) $element, $this->state)
        );

        $span = new Span($this->output, $state, $this->properties);

        return $span->toString();
    }

    /**
     * Renders the string representation of the element on the output.
     */
    public function render(): void
    {
        $this->output->writeln($this->toString());
    }
}
