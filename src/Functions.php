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
     *
     * @param OutputInterface|null $renderer
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
     *
     * @param string $value
     * @param string $styles
     *
     * @return Components\Span
     */
    function span(string $value = '', string $styles = ''): Components\Span
    {
        return Termwind::span($value, $styles);
    }
}

if (! function_exists('style')) {
    /**
     * Creates a new style.
     *
     * @template TElement of Element
     *
     * @param string       $name
     * @param Closure|null $callback
     *
     * @return Style<TElement>
     */
    function style(string $name, Closure $callback = null): Style
    {
        return Styles::create($name, $callback);
    }
}
