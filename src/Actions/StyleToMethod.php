<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Components\Element;
use Termwind\Exceptions\StyleNotFound;
use Termwind\Repositories\Styles;

/**
 * @internal
 */
final class StyleToMethod
{
    /**
     * Creates a new action instance.
     *
     * @param  Element  $element
     */
    public function __construct(
        private Element $element,
        private string $style,
    ) {
        // ..
    }

    /**
     * Applies multiple styles to the given element.
     *
     * @template TElement of Element
     *
     * @param  TElement  $element
     * @return TElement
     */
    public static function multiple(Element $element, string $styles): Element
    {
        $styles = array_merge($element->defaultStyles, explode(' ', $styles));

        $styles = array_filter($styles, static function ($style): bool {
            return $style !== '';
        });

        foreach ($styles as $style) {
            $element = (new self($element, $style))->__invoke();
        }

        /** @var TElement $element */
        return $element;
    }

    /**
     * Converts the given style to a method name.
     *
     * @return Element
     */
    public function __invoke(string|int ...$arguments): Element
    {
        if (Styles::has($this->style)) {
            $element = Styles::get($this->style)($this->element, ...$arguments);

            return $element;
        }

        $method = explode('-', $this->style);
        $method = array_slice($method, 0, count($method) - count($arguments));

        $methodName = implode(' ', $method);

        $methodName = ucwords($methodName);
        $methodName = lcfirst($methodName);
        $methodName = str_replace(' ', '', $methodName);

        if ($methodName === '') {
            throw StyleNotFound::fromStyle($this->style);
        }

        if (! method_exists($this->element, $methodName)) {
            $argument = array_pop($method);

            $arguments[] = is_numeric($argument) ? (int) $argument : (string) $argument;

            return $this->__invoke(...$arguments);
        }

        return $this->element->$methodName(...array_reverse($arguments));
    }
}
