<?php

declare(strict_types=1);

namespace NunoMaduro\TailCli;

use NunoMaduro\TailCli\Components;

final class TailCli
{
    /**
     * Creates a line element instance with the given style.
     */
    public static function line(string $value = '', string $styles = ''): Components\Line
    {
        return Components\Line::fromStyles($value, $styles);
    }
}
