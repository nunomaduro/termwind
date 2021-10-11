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
     * @param  array<int, Element|string>|string  $content
     */
    public static function div(array|string $content = '', string $styles = ''): Components\Div
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Div::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a span element instance with the given style.
     */
    public static function span(string $content = '', string $styles = ''): Components\Span
    {
        return Components\Span::fromStyles(
            self::getRenderer(), $content, $styles,
        );
    }

    /**
     * Creates an anchor element instance with the given style.
     */
    public static function anchor(string $content = '', string $styles = ''): Components\Anchor
    {
        return Components\Anchor::fromStyles(
            self::getRenderer(), $content, $styles,
        )->href($content);
    }

    /**
     * Creates an break line element instance.
     */
    public static function breakLine(): Components\BreakLine
    {
        return Components\BreakLine::fromStyles(
            self::getRenderer(), '', '',
        );
    }

    /**
     * Gets the current renderer instance.
     */
    private static function getRenderer(): OutputInterface
    {
        return self::$renderer ??= new ConsoleOutput();
    }
}
