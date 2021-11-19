<?php

declare(strict_types=1);

namespace Termwind\Html;

use Termwind\Components\Element;
use Termwind\Termwind;
use Termwind\ValueObjects\Styles;

/**
 * @internal
 */
final class InheritStyles
{
    /**
     * Applies styles from parent element to child elements.
     *
     * @param  array<int, Element|string>  $elements
     *
     * @return   array<int, Element|string>
     */
    public function __invoke(array $elements, Styles $styles): array
    {
        if (! $styles->hasInheritableStyles()) {
            return $elements;
        }

        foreach ($elements as &$element) {
            if (is_string($element)) {
                $element = Termwind::raw($element);
            }

            $element->inheritFromStyles($styles);
        }

        return $elements;
    }
}
