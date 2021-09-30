<?php

declare(strict_types=1);

namespace Termwind;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;

if (! function_exists('line')) {
    /**
     * Creates a line element instance with the given style.
     */
    function line(string $value = ''): Components\Line
    {
        return Termwind::line($value);
    }
}

if (! function_exists('renderUsing')) {
    /**
     * Sets the renderer implementation.
     */
    function renderUsing(OutputInterface|null $renderer): void
    {
        Termwind::renderUsing($renderer);
    }
}

if (! function_exists('render')) {
    /**
     * Renders the given elements.
     *
     * @param  array<int, Element|array<int, Element>>  $elements
     */
    function render(array $elements): void
    {
        Termwind::render($elements);
    }
}
