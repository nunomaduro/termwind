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
    public function __invoke(array $elements, Styles $styles): array
    {
        $elements = array_values($elements);

        if (! $styles->hasInheritableStyles() || count($elements) < 1) {
            return $elements;
        }

        foreach ($elements as &$element) {
            if (is_string($element)) {
                $element = Termwind::raw($element);
            }

            $element->inheritFromStyles($styles);
        }

        if ((bool) ($styles->getProperties()['styles']['spaceBetween'] ?? false)) {
            /** @var Element[] $elements */
            $totalWidth = (int) array_reduce($elements, fn ($carry, $element) => $carry += $element->getLength(), 0);
            $parentWidth = Styles::getParentWidth($elements[0]->getProperties()['parentStyles'] ?? []);
            $spaceBetween = ($parentWidth - $totalWidth) / (count($elements) - 1);

            if ($spaceBetween < 1) {
                return $elements;
            }

            $arr = [];
            foreach ($elements as $index => &$element) {
                if ($index !== 0) {
                    // Since there is no float pixel, on the last one it should round up...
                    $length = $index === count($elements) - 1 ? ceil($spaceBetween) : floor($spaceBetween);
                    $arr[] = str_repeat(' ', (int) $length);
                }

                $arr[] = $element;
            }

            return $arr;
        }

        return $elements;
    }
}
