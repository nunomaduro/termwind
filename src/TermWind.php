<?php

declare(strict_types=1);

namespace TermWind;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use TermWind\Components\Element;

/**
 * @internal
 */
final class TermWind
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
        self::$renderer = $renderer;
    }

    /**
     * Creates a line element instance with the given style.
     */
    public static function line(string $value = ''): Components\Line
    {
        return new Components\Line(
            self::$renderer ?? new ConsoleOutput(), $value
        );
    }

    /**
     * Renders the given elements.
     *
     * @param  array<int, Element|array<int, Element>>  $elements
     */
    public static function render(array $elements): void
    {
        $renderer = self::$renderer ?? new ConsoleOutput();

        foreach ($elements as $element) {
            if (is_array($element)) {
                $renderer->write(array_map(static fn ($element) => $element->toString(), $element));

                $renderer->writeln(['']);

                continue;
            }

            $renderer->writeln($element->toString());
        }
    }
}
