<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Contracts\Renderable;
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
     * Renders the given renderables.
     *
     * @param  array<int, Renderable|array<int, Renderable>>  $renderables
     */
    function render(array $renderables): void
    {
        Termwind::render($renderables);
    }
}

if (! function_exists('div')) {
    /**
     * Creates a div element instance.
     *
     * @param  array<int, Renderable>  $value
     */
    function div(array $value = []): Components\Div
    {
        return Termwind::div($value);
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
     * @param (Closure(Renderable $renderable, string|int ...$arguments): Renderable)|null $callback
     */
    function style(string $name, Closure $callback = null): Style
    {
        return Styles::create($name, $callback);
    }
}
