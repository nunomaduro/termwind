<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Exceptions\InvalidRenderer;
use Termwind\Repositories\Styles as StyleRepository;
use Termwind\Select;
use Termwind\ValueObjects\Style;
use Termwind\ValueObjects\Styles;

if (! function_exists('Termwind\renderUsing')) {
    /**
     * Sets the renderer implementation.
     */
    function renderUsing(OutputInterface|null $renderer): void
    {
        Termwind::renderUsing($renderer);
    }
}

if (! function_exists('Termwind\style')) {
    /**
     * Creates a new style.
     *
     * @param (Closure(Styles $renderable, string|int ...$arguments): Styles)|null $callback
     */
    function style(string $name, Closure $callback = null): Style
    {
        return StyleRepository::create($name, $callback);
    }
}

if (! function_exists('Termwind\render')) {
    /**
     * Render HTML to a string.
     */
    function render(string $html): void
    {
        (new HtmlRenderer)->render($html);
    }
}

if (! function_exists('Termwind\terminal')) {
    /**
     * Returns a Terminal instance.
     */
    function terminal(): Terminal
    {
        return new Terminal;
    }
}

if (! function_exists('Termwind\ask')) {
    /**
     * Renders a prompt to the user.
     */
    function ask(string $question): string|null
    {
        return (new Question)->ask($question);
    }
}

if (! function_exists('live')) {
    /**
     * Render HTML to a string, and keeps the html live.
     */
    function live(Closure $htmlResolver): Live
    {
        $output = Termwind::getRenderer();

        if (! $output instanceof ConsoleOutput) {
            throw new InvalidRenderer(
                'The renderer must be an instance of Symfony\'s ConsoleOutput',
            );
        }

        $live = new Live(terminal(), $output->section(), new HtmlRenderer(), $htmlResolver);

        $live->render();

        return $live;
    }
}

if (! function_exists('Termwind\select')) {
    /**
     * Renders a prompt to the user with the capability to select an option.
     *
     * @param  array<int, array<string, mixed>>  $options
     */
    function select(Closure $htmlResolver, array $options): Select
    {
        $output = Termwind::getRenderer();

        if (! $output instanceof ConsoleOutput) {
            throw new InvalidRenderer(
                'The renderer must be an instance of Symfony\'s ConsoleOutput',
            );
        }

        $select = new Select(terminal(), $output, $options, $htmlResolver);

        return $select;
    }
}
