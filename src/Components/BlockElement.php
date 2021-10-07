<?php

declare(strict_types=1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
abstract class BlockElement
{
    /**
     * Renders the string representation of the block element on the output.
     */
    final public function render(): void
    {
        $this->output->writeln($this->toString());
    }

    /**
     * Creates a block element instance.
     *
     * @param  array<int, Element>  $elements
     */
    final public function __construct(
        protected OutputInterface $output,
        protected array $elements)
    {
        // ..
    }

    /**
     * Get the string representation of the element.
     */
    final public function toString(): string
    {
        return implode('', array_map(
            fn ($element) => (string) $element, $this->elements)
        );
    }

    /**
     * Get the string representation of the element.
     */
    final public function __toString(): string
    {
        return $this->toString();
    }
}
