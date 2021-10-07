<?php

declare(strict_types=1);

namespace Termwind\Repositories;

use Closure;
use Termwind\Contracts\Renderable;
use Termwind\Exceptions\StyleNotFound;
use Termwind\ValueObjects\Style;

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
     * @param (Closure(Renderable $renderable, string|int ...$arguments): Renderable)|null $callback
     * @return Style
     */
    public static function create(string $name, Closure $callback = null): Style
    {
        self::$storage[$name] = $style = new Style($callback ?? static fn (Renderable $renderable) => $renderable);

        return $style;
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
        if (! self::has($name)) {
            throw StyleNotFound::fromStyle($name);
        }

        return self::$storage[$name];
    }
}
