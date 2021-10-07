<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Closure;
use Termwind\Actions\StyleToMethod;
use Termwind\Contracts\Renderable;

/**
 * @internal
 */
final class Style
{
    /**
     * Creates a new value object instance.
     *
     * @param Closure(Renderable $renderable, string|int ...$argument): Renderable  $callback
     */
    public function __construct(private Closure $callback)
    {
        // ..
    }

    /**
     * Apply the given set of styles to the renderable.
     */
    public function apply(string $styles): void
    {
        $callback = clone $this->callback;

        $this->callback = static function (Renderable $renderable, string|int ...$arguments) use ($callback, $styles): Renderable {
            $renderable = $callback($renderable, ...$arguments);

            return StyleToMethod::multiple($renderable, $styles);
        };
    }

    /**
     * Styles the given renderable with this style.
     *
     * @param  Renderable  $renderable
     * @return Renderable
     */
    public function __invoke(Renderable $renderable, string|int ...$arguments): Renderable
    {
        return ($this->callback)($renderable, ...$arguments);
    }
}
