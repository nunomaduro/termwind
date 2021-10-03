<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Closure;
use Termwind\Actions\StyleToMethod;
use Termwind\Components\Element;

/**
 * @template TElement of Element
 *
 * @internal
 */
final class Style
{
    /**
     * Creates a new value object instance.
     *
     * @param Closure(TElement $element, string|int ...$argument): TElement  $callback
     */
    public function __construct(private Closure $callback)
    {
        // ..
    }

    /**
     * Apply the given set of styles to the element.
     *
     * @param string $styles
     */
    public function apply(string $styles): void
    {
        $callback = clone $this->callback;

        $this->callback = static function (Element $element, string|int ...$arguments) use ($callback, $styles): Element {
            // @phpstan-ignore-next-line
            $element = $callback($element, ...$arguments);

            return StyleToMethod::multiple($element, $styles);
        };
    }

    /**
     * Styles the given element with this style.
     *
     * @param Element    $element
     * @param string|int ...$arguments
     *
     * @return Element
     */
    public function __invoke(Element $element, string|int ...$arguments): Element
    {
        return ($this->callback)($element, ...$arguments);
    }
}
