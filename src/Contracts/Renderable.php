<?php

declare(strict_types=1);

namespace Termwind\Contracts;

interface Renderable
{
    /**
     * Renders the element to the output.
     */
    public function render(): void;

    /**
     * Get the string representation of the element.
     */
    public function toString(): string;

    /**
     * Get the string representation of the element.
     */
    public function __toString(): string;
}
