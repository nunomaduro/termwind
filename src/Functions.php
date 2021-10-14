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

if (! function_exists('terminal')) {
    /**
     * Returns a Terminal instance.
     */
    function terminal(): Terminal
    {
        return new Terminal;
    }
}
