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
     *
     * @param OutputInterface|null $renderer
     */
    public static function renderUsing(OutputInterface|null $renderer): void
    {
        self::$renderer = $renderer ?? new ConsoleOutput();
    }

    /**
     * Creates a span element instance with the given style.
     *
     * @param string $value
     * @param string $styles
     *
     * @return Components\Span
     */
    public static function span(string $value = '', string $styles = ''): Components\Span
    {
        return Components\Span::fromStyles(
            self::getRenderer(), $value, $styles,
        );
    }

    /**
     * Renders the given elements.
     *
     * @param array $elements
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
     *
     * @return OutputInterface
     */
    private static function getRenderer(): OutputInterface
    {
        return self::$renderer ??= new ConsoleOutput();
    }
}
