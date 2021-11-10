<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Closure;
use Termwind\Actions\StyleToMethod;
use Termwind\Components\Element;
use Termwind\Exceptions\InvalidColor;

/**
 * @internal
 */
final class Style
{
    /**
     * Creates a new value object instance.
     *
     * @param Closure(Element $element, string|int ...$argument): Element  $callback
     */
    public function __construct(private Closure $callback, private string $color = '')
    {
        // ..
    }

    /**
     * Apply the given set of styles to the element.
     */
    public function apply(string $styles): void
    {
        $callback = clone $this->callback;

        $this->callback = static function (Element $element, string|int ...$arguments) use ($callback, $styles): Element {
            $element = $callback($element, ...$arguments);

            return StyleToMethod::multiple($element, $styles);
        };
    }

    /**
     * Sets the color to the style.
     */
    public function color(string $color): void
    {
        if (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $color) < 1) {
            throw new InvalidColor(sprintf('The color %s is invalid.', $color));
        }

        $this->color = $color;
    }

    /**
     * Gets the color.
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * Styles the given element with this style.
     *
     * @param  Element  $element
     * @return Element
     */
    public function __invoke(Element $element, string|int ...$arguments): Element
    {
        return ($this->callback)($element, ...$arguments);
    }
}
