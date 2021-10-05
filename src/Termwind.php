<?php

declare(strict_types=1);

namespace Termwind;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;

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
     * @param  array<int, Element>  $value
     */
    public static function div(array $value = []): Components\Div
    {
        return new Components\Div(
            self::getRenderer(), $value,
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
     * Renders the given elements.
     *
     * @param  array<int, Element|array<int, Element>>  $elements
     */
    public static function render(array $elements): void
    {
        foreach ($elements as $element) {
            if (is_array($element)) {
                self::getRenderer()->write(array_map(static fn ($element) => (string) $element, $element));

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
