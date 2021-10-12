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

if (! function_exists('strong')) {
    /**
     * Create a span element instance with a bold font and the given style.
     */
    function strong(string $content = '', string $styles = ''): Components\Span
    {
        return Termwind::span($content, $styles)->fontBold();
    }
}

if (! function_exists('em')) {
    /**
     * Create a span element instance with an italic font and the given style.
     */
    function em(string $content = '', string $styles = ''): Components\Span
    {
        return Termwind::span($content, $styles)->italic();
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

if (! function_exists('ul')) {
    /**
     * Creates an unordered list instance.
     *
     * @param  array<int, Element>  $content
     */
    function ul(array $content = [], string $styles = ''): Components\Ul
    {
        return Termwind::ul($content, $styles);
    }
}

if (! function_exists('ol')) {
    /**
     * Creates an ordered list instance.
     *
     * @param  array<int, Element>  $content
     */
    function ol(array $content = [], string $styles = ''): Components\Ol
    {
        return Termwind::ol($content, $styles);
    }
}

if (! function_exists('li')) {
    /**
     * Creates a list item instance.
     *
     * @param  array<int, Element>|string  $content
     */
    function li(array|string $content = [], string $styles = ''): Components\Li
    {
        return Termwind::li($content, $styles);
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
     */
    function render(string $html): void
    {
        (new HtmlRenderer)->render($html);
    }
}
