<?php

declare(strict_types=1);

namespace Termwind;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Contracts\Renderable;

/**
 * @internal
 */
final class Termwind
{
    /**
     * The implementation of the output.
     */
    private static OutputInterface|null $renderer;

    /**
     * Sets the renderer implementation.
     */
    public static function renderUsing(OutputInterface|null $renderer): void
    {
        self::$renderer = $renderer ?? new ConsoleOutput();
    }

    /**
     * Creates a div element instance.
     *
     * @param  array<int, Renderable>|string  $value
     */
    public static function div(array|string $value = '', string $styles = ''): Components\Div
    {
        $elements = is_array($value) ? $value : [span($value)];

        return Components\Div::fromStyles(
            self::getRenderer(), $elements, $styles
        );
    }

    /**
     * Creates a span element instance with the given style.
     */
    public static function span(string $value = '', string $styles = ''): Components\Span
    {
        return Components\Span::fromStyles(
            self::getRenderer(), $value, $styles,
        );
    }

    /**
     * Creates an anchor element instance with the given style.
     */
    public static function anchor(string $value = '', string $styles = ''): Components\Anchor
    {
        return Components\Anchor::fromStyles(
            self::getRenderer(), $value, $styles,
        )->href($value);
    }

    /**
     * Renders the given renderables.
     *
     * @param  array<int, Renderable|array<int, Renderable>>  $renderables
     */
    public static function render(array $renderables): void
    {
        foreach ($renderables as $element) {
            if (is_array($element)) {
                self::getRenderer()->write(array_map(static fn (Renderable $element) => (string) $element, $element));

                self::getRenderer()->writeln(['']);

                continue;
            }

            self::getRenderer()->writeln($element->toString());
        }
    }

    /**
     * Gets the current renderer instance.
     */
    private static function getRenderer(): OutputInterface
    {
        return self::$renderer ??= new ConsoleOutput();
    }
}
