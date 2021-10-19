<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Repositories\Styles;
use Termwind\ValueObjects\Style;
use Termwind\ValueObjects\StylesFormatter;

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
     * @param (Closure(StylesFormatter $renderable, string|int ...$arguments): StylesFormatter)|null $callback
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
