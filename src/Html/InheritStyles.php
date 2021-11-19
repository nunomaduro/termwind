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
     * @return array<int, Element|string>
     */
    public function __invoke(array $elements, string $styles = ''): array
    {
        $styles = Styles::fromStyles($styles);

        if (! $styles->hasInheritableStyles()) {
            return $elements;
        }

        foreach ($elements as &$element) {
            $toString = false;
            if (is_string($element)) {
                $element = Termwind::raw($element);
                $toString = true;
            }

            $element->inheritFromStyles($styles);

            if ($toString) {
                $element = (string) $element;
            }
        }

        return $elements;
    }
}
