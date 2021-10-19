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
     * @return Element[]
     */
    public function __invoke(?Closure $closure): array
    {
        foreach ($this->elements as $i => $element) {
            if (is_string($element)) {
                $this->elements[$i] = $element = Termwind::raw($element);
            }

            $element->inheritFromStyles($this->styles);

            if ($closure) {
                $this->elements[$i] = $closure($element);
            }
        }

        return $this->elements;
    }
}
