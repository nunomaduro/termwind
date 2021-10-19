<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\InheritStyles;
use Termwind\Components\Element;
use Termwind\Exceptions\InvalidChild;

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
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Div::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a span element instance with the given style.
     *
     * @param  array<int, Element|string>|string  $content
     */
    public static function span(array|string $content = '', string $styles = ''): Components\Span
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Span::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates an anchor element instance with the given style.
     *
     * @param  array<int, Element|string>|string  $content
     */
    public static function anchor(array|string $content = '', string $styles = ''): Components\Anchor
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Anchor::fromStyles(
            self::getRenderer(), $content, $styles,
        );
    }

    /**
     * Creates an unordered list instance.
     *
     * @param  array<int, string|Element>  $content
     */
    public static function ul(array $content = [], string $styles = ''): Components\Ul
    {
        $index = 0;
        $content = self::prepareElements(
            self::inheritStyles($content, $styles, static function (Element $element) use (&$index) {
                if (! $element instanceof Components\Li) {
                    throw new InvalidChild('Unordered lists only accept `li` as child');
                }

                $index++;

                return $element
                    ->prepend('• ')
                    ->mt($index > 1 ? 1 : 0);
            })
        );

        return Components\Ul::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates an ordered list instance.
     *
     * @param  array<int, string|Element>  $content
     */
    public static function ol(array $content = [], string $styles = ''): Components\Ol
    {
        $index = 0;

        $content = self::prepareElements(
            self::inheritStyles($content, $styles, static function (Element $element) use (&$index) {
                if (! $element instanceof Components\Li) {
                    throw new InvalidChild('Ordered lists only accept `li` as child');
                }

                return $element
                    ->prepend(sprintf('%s. ', ++$index))
                    ->mt($index > 1 ? 1 : 0);
            })
        );

        return Components\Ol::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a list item instance.
     *
     * @param  array<int, Element|string>|string  $content
     */
    public static function li(array|string $content = '', string $styles = ''): Components\Li
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Li::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a description list instance.
     *
     * @param  array<int, string|Element>  $content
     */
    public static function dl(array $content = [], string $styles = ''): Components\Dl
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles, static function (Element $element) {
                if (! $element instanceof Components\Dt && ! $element instanceof Components\Dd) {
                    throw new InvalidChild('Description lists only accept `dt` and `dd` as children');
                }

                $element = $element->mt(1);

                if ($element instanceof Components\Dt) {
                    return $element;
                }

                return $element->ml(4);
            })
        );

        return Components\Dl::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a description term instance.
     *
     * @param  array<int, Element|string>|string  $content
     */
    public static function dt(array|string $content = '', string $styles = ''): Components\Dt
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Dt::fromStyles(
            self::getRenderer(), $content, $styles
        )->fontBold();
    }

    /**
     * Creates a description details instance.
     *
     * @param  array<int, Element|string>|string  $content
     */
    public static function dd(array|string $content = '', string $styles = ''): Components\Dd
    {
        $content = self::prepareElements(
            self::inheritStyles($content, $styles)
        );

        return Components\Dd::fromStyles(
            self::getRenderer(), $content, $styles
        );
    }

    /**
     * Creates a break line element instance.
     */
    public static function breakLine(): Components\BreakLine
    {
        return Components\BreakLine::fromStyles(
            self::getRenderer(), '', '',
        );
    }

    /**
     * @internal
     * Creates a raw element instance.
     */
    public static function raw(string $content = ''): Components\Span
    {
        return Components\Span::fromStyles(
            self::getRenderer(), $content, '',
        );
    }

    /**
     * Gets the current renderer instance.
     */
    private static function getRenderer(): OutputInterface
    {
        return self::$renderer ??= new ConsoleOutput();
    }

    /**
     * Adds root styles to child elements.
     */
    private static function inheritStyles($content, string $styles = '', Closure $callback = null): array
    {
        $content = is_array($content) ? $content : [$content];

        return (new InheritStyles($content, $styles))($callback);
    }

    /**
     * Convert child elements to a string.
     */
    private static function prepareElements(array $elements): string
    {
        return implode('', array_map(
            fn ($element) => (string) $element,
            $elements
        ));
    }
}
