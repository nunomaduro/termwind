<?php

declare(strict_types=1);

namespace NunoMaduro\TailCli;

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
        return Components\Line::fromStyles(self::$output ?? new ConsoleOutput(), $value, $styles);
    }
}
