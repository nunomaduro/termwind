<?php

declare(strict_types=1);

namespace Termwind\Repositories;

use Closure;
use Termwind\ValueObjects\Style;
use Termwind\ValueObjects\StylesFormatter;

/**
 * @internal
 */
final class Styles
{
    /**
     * @var array<string, Style>
     */
    private static array $storage = [];

    /**
     * Creates a new style from the given arguments.
     *
     * @param (Closure(StylesFormatter $element, string|int ...$arguments): StylesFormatter)|null $callback
     * @return Style
     */
    public static function create(string $name, Closure $callback = null): Style
    {
        self::$storage[$name] = $style = new Style($callback ?? static fn (StylesFormatter $formatter) => $formatter);

        return $style;
    }

    /**
     * Removes all existing styles.
     */
    public static function flush(): void
    {
        self::$storage = [];
    }

    /**
     * Checks a style with the given name exists.
     */
    public static function has(string $name): bool
    {
        return array_key_exists($name, self::$storage);
    }

    /**
     * Gets the style with the given name.
     */
    public static function get(string $name): Style
    {
        return self::$storage[$name];
    }
}
