<?php

declare(strict_types=1);

namespace Termwind;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;

if (! function_exists('span')) {
    /**
     * Creates a span element instance with the given style.
     */
    function span(string $value = '', string $styles = ''): Components\Span
    {
        return Termwind::span($value, $styles);
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
