<?php

declare(strict_types=1);

namespace NunoMaduro\TailCli;

use NunoMaduro\TailCli\Components\Element;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;

final class TailCli
{
    /**
     * The implementation of the output.
     */
    private static OutputInterface|null $output;

    /**
     * Sets the output implementation.
     */
    public static function outputUsing(OutputInterface|null $output): void
    {
        self::$output = $output;
    }

    /**
     * Creates a line element instance with the given style.
     */
    public static function line(string $value = '', string $styles = ''): Components\Line
    {
        return new Components\Line(
            self::$output ?? new ConsoleOutput(), $value
        );
    }

    /**
     * Renders the given elements.
     *
     * @template TElement of Element
     *
     * @param array<int, TElement|array<int, TElement>> $elements
     */
    public static function render(array $elements): void
    {
        $output = self::$output ?? new ConsoleOutput();

        foreach ($elements as $element) {
            if (is_array($element)) {
                $output->write(array_map(static fn ($element) => $element->toString(), $element), true);

                continue;
            }

            $output->writeln($element->toString());
        }
    }
}
