<?php

declare(strict_types=1);

namespace Termwind;

use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
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
     * @param  array<string, mixed>  $properties
     */
    public static function div(array|string $content = '', string $styles = '', array $properties = []): Components\Div
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Div::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates a paragraph element instance.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function paragraph(array|string $content = '', string $styles = '', array $properties = []): Components\Paragraph
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Paragraph::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates a span element instance with the given style.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function span(array|string $content = '', string $styles = '', array $properties = []): Components\Span
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Span::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates an element instance with raw content.
     */
    public static function raw(string $content = ''): Components\Raw
    {
        return Components\Raw::fromStyles(
            self::getRenderer(), $content, ''
        );
    }

    /**
     * Creates an anchor element instance with the given style.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function anchor(array|string $content = '', string $styles = '', array $properties = []): Components\Anchor
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Anchor::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates an unordered list instance.
     *
     * @param  array<int, string|Element>  $content
     * @param  array<string, mixed>  $properties
     */
    public static function ul(array $content = [], string $styles = '', array $properties = []): Components\Ul
    {
        $ul = Components\Ul::fromStyles(
            self::getRenderer(), '', $styles, $properties
        );

        $content = implode('', array_map(function ($li) use ($ul): string {
            if (is_string($li)) {
                return $li;
            }

            if (! $li instanceof Components\Li) {
                throw new InvalidChild('Unordered lists only accept `li` as child');
            }

            return (string) match (true) {
                $li->hasStyle('list-none') => $li,
                $ul->hasStyle('list-none') => $li->addStyle('list-none'),
                $ul->hasStyle('list-square') => $li->addStyle('list-square'),
                $ul->hasStyle('list-disc') => $li->addStyle('list-disc'),
                default => $li->addStyle('list-none'),
            };
        }, $content));

        return $ul->setContent($content);
    }

    /**
     * Creates an ordered list instance.
     *
     * @param  array<int, string|Element>  $content
     * @param  array<string, mixed>  $properties
     */
    public static function ol(array $content = [], string $styles = '', array $properties = []): Components\Ol
    {
        $ol = Components\Ol::fromStyles(
            self::getRenderer(), '', $styles, $properties
        );

        $index = 0;
        $content = implode('', array_map(function ($li) use ($ol, &$index): string {
            if (is_string($li)) {
                return $li;
            }

            if (! $li instanceof Components\Li) {
                throw new InvalidChild('Ordered lists only accept `li` as child');
            }

            return (string) match (true) {
                $li->hasStyle('list-none') => $li->addStyle('list-none'),
                $ol->hasStyle('list-none') => $li->addStyle('list-none'),
                $ol->hasStyle('list-decimal') => $li->addStyle('list-decimal-'.(++$index)),
                default => $li->addStyle('list-none'),
            };
        }, $content));

        return $ol->setContent($content);
    }

    /**
     * Creates a list item instance.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function li(array|string $content = '', string $styles = '', array $properties = []): Components\Li
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Li::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates a description list instance.
     *
     * @param  array<int, string|Element>  $content
     * @param  array<string, mixed>  $properties
     */
    public static function dl(array $content = [], string $styles = '', array $properties = []): Components\Dl
    {
        $text = implode('', array_map(function ($element): string {
            if (is_string($element)) {
                return $element;
            }

            if (! $element instanceof Components\Dt && ! $element instanceof Components\Dd) {
                throw new InvalidChild('Description lists only accept `dt` and `dd` as children');
            }

            return (string) $element;
        }, $content));

        return Components\Dl::fromStyles(
            self::getRenderer(), $text, $styles, $properties
        );
    }

    /**
     * Creates a description term instance.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function dt(array|string $content = '', string $styles = '', array $properties = []): Components\Dt
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Dt::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates a description details instance.
     *
     * @param  array<int, Element|string>|string  $content
     * @param  array<string, mixed>  $properties
     */
    public static function dd(array|string $content = '', string $styles = '', array $properties = []): Components\Dd
    {
        $content = implode('', array_map(
            fn ($element) => (string) $element, is_array($content) ? $content : [$content]
        ));

        return Components\Dd::fromStyles(
            self::getRenderer(), $content, $styles, $properties
        );
    }

    /**
     * Creates a horizontal rule instance.
     *
     * @param  array<string, mixed>  $properties
     */
    public static function hr(string $styles = '', array $properties = []): Components\Hr
    {
        $width = terminal()->width();

        return Components\Hr::fromStyles(
            self::getRenderer(), str_repeat(html_entity_decode('&mdash;'), $width), $styles, $properties
        );
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
