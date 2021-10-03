<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;
use Termwind\Repositories\Styles;
use Termwind\ValueObjects\Style;

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

if (! function_exists('span')) {
    /**
     * Creates a span element instance with the given style.
     */
    function span(string $value = '', string $styles = ''): Components\Span
    {
        return Termwind::span($value, $styles);
    }
}

if (! function_exists('a')) {
    /**
     * Creates a line element instance with the given link.
     */
    function a(string $value = '', string $styles = ''): Components\Anchor
    {
        return Termwind::anchor($value, $styles);
    }
}

if (! function_exists('style')) {
    /**
     * Creates a new style.
     *
     * @template TElement of Element
     *
     * @param (Closure(TElement $element, string|int ...$arguments): TElement)|null $callback
     * @return Style<TElement>
     */
    function style(string $name, Closure $callback = null): Style
    {
        return Styles::create($name, $callback);
    }
}
