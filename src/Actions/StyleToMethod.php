<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Components\Element;
use Termwind\Exceptions\StyleNotFound;
use Termwind\Repositories\Styles;

/**
 * @internal
 *
 * @template TElement of Element
 */
final class StyleToMethod
{
    /**
     * Creates a new action instance.
     *
     * @param Element $element
     * @param string  $style
     */
    public function __construct(private Element $element, private string $style) {
        // ..
    }

    /**
     * @template TStylesElement of Element
     *
     * @param Element $element
     * @param string  $styles
     *
     * @return Element
     */
    public static function multiple(Element $element, string $styles): Element
    {
        $styles = explode(' ', $styles);

        $styles = array_filter($styles, static function ($style): bool {
            return $style !== '';
        });

        foreach ($styles as $style) {
            $element = (new self($element, $style))->__invoke();
        }

        return $element;
    }

    /**
     * Converts the given style to a method name.
     *
     * @param string|int ...$arguments
     *
     * @return Element
     */
    public function __invoke(string|int ...$arguments): Element
    {
        if (Styles::has($this->style)) {
            return Styles::get($this->style)($this->element, ...$arguments);
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

        return $this->element->$methodName(...$arguments);
    }
}
