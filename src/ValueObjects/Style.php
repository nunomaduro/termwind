<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Closure;
use Termwind\Actions\StyleToMethod;

/**
 * @internal
 */
final class Style
{
    /**
     * Creates a new value object instance.
     *
     * @param Closure(StylesFormatter $formatter, string|int ...$argument): StylesFormatter  $callback
     */
    public function __construct(private Closure $callback)
    {
        // ..
    }

    /**
     * Apply the given set of styles to the formatter.
     */
    public function apply(string $styles): void
    {
        $callback = clone $this->callback;

        $this->callback = static function (StylesFormatter $formatter, string|int ...$arguments) use ($callback, $styles): StylesFormatter {
            $formatter = $callback($formatter, ...$arguments);

            return StyleToMethod::multiple($formatter, $styles);
        };
    }

    /**
     * Styles the given formatter with this style.
     *
     * @param  StylesFormatter  $formatter
     * @return StylesFormatter
     */
    public function __invoke(StylesFormatter $formatter, string|int ...$arguments): StylesFormatter
    {
        return ($this->callback)($formatter, ...$arguments);
    }
}
