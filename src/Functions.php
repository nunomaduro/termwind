<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
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

if (!function_exists('register_preset')) {
    function register_preset(string $name,  Closure $style): void
    {
        Preset::register($name, $style);
    }
}

if (!function_exists('render_preset')) {
    function render_preset(string $message, string $preset): mixed
    {
        return Preset::design($message, $preset);
    }
}
