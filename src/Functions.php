<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;
use Termwind\Repositories\Styles;
use Termwind\ValueObjects\Style;

if (! function_exists('br')) {
    /**
     * Creates a br element instance.
     */
    function br(): Components\BreakLine
    {
        return Termwind::breakLine();
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

if (! function_exists('div')) {
    /**
     * Creates a div element instance.
     *
     * @param  array<int, Element>|string  $content
     */
    function div(array|string $content = [], string $styles = ''): Components\Div
    {
        return Termwind::div($content, $styles);
    }
}

if (! function_exists('span')) {
    /**
     * Creates a span element instance with the given style.
     */
    function span(string $content = '', string $styles = ''): Components\Span
    {
        return Termwind::span($content, $styles);
    }
}

if (! function_exists('a')) {
    /**
     * Creates a line element instance with the given link.
     */
    function a(string $content = '', string $styles = ''): Components\Anchor
    {
        return Termwind::anchor($content, $styles);
    }
}

if (! function_exists('style')) {
    /**
     * Creates a new style.
     *
     * @param (Closure(Element $renderable, string|int ...$arguments): Element)|null $callback
     */
    function style(string $name, Closure $callback = null): Style
    {
        return Styles::create($name, $callback);
    }
}

if (! function_exists('render')) {
    /**
     * Render HTML to a string.
     *
     * @param  string  $html
     */
    function render(string $html): Components\Element
    {
        return (new HtmlRenderer)->render($html);
    }
}
