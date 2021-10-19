<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Closure;
use Termwind\Components\Element;
use Termwind\Termwind;
use Termwind\ValueObjects\StylesFormatter;

/**
 * @internal
 */
final class InheritStyles
{
    private StylesFormatter $styles;

    /**
     * @param  string[]|Element[]  $elements
     * @param  string  $styles
     */
    public function __construct(
        private array $elements,
        string $styles = ''
    ) {
        $this->styles = StylesFormatter::fromStyles($styles);
    }

    /**
     * Applies styles from parent element to child elements.
     *
     * @param  null|Closure(Element): Element  $callback
     * @return array<Element>
     */
    public function __invoke(Closure|null $callback = null): array
    {
        /** @var array<Element> $elements */
        $elements = [];

        foreach ($this->elements as $i => $element) {
            if (is_string($element)) {
                $element = Termwind::raw($element);
            }

            $element->inheritFromStyles($this->styles);

            if (! is_null($callback)) {
                $element = $callback($element);
            }

            $elements[] = $element;
        }

        return $elements;
    }
}
