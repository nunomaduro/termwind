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
     * Creates a line element instance with the given style.
     */
    public static function line(string $value = ''): Components\Line
    {
        return new Components\Line(
            self::getRenderer(), $value
        );
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
        if (self::$renderer === null) {
            self::$renderer = new ConsoleOutput();
        }

        return self::$renderer;
    }
}
