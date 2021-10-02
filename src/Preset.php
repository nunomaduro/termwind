<?php
declare(strict_types=1);

namespace Termwind;

use Closure;
use Termwind\Exceptions\UndefinedTermwindPresetException;

final class Preset
{
    /**
     * @var array<string, callable> $presets
     */
    public static array $presets = [];

    /**
     * Register a new preset with some styles
     *
     * @param string $name
     * @param Closure $styles
     */
    public static function register(string $name, Closure $styles): void
    {
        self::$presets[$name] = $styles;
    }

    /**
     * Design a message with a predefined preset
     *
     * @param string $message
     * @param string $presetName
     * @return mixed
     * @throws UndefinedTermwindPresetException
     */
    public static function design(string $message, string $presetName): mixed
    {
        if (!array_key_exists($presetName, self::$presets)) {
            throw new UndefinedTermwindPresetException($presetName);
        }

        return call_user_func(self::$presets[$presetName], $message);
    }


}
