<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Exceptions\StyleNotFound;
use Termwind\Repositories\Styles;
use Termwind\ValueObjects\StylesFormatter;

/**
 * @internal
 */
final class StyleToMethod
{
    /**
     * Creates a new action instance.
     *
     * @param  StylesFormatter $formatter
     */
    public function __construct(
        private StylesFormatter $formatter,
        private string $style,
    ) {
        // ..
    }

    /**
     * Applies multiple styles to the given element.
     *
     * @template TElement of StylesFormatter
     *
     * @param  StylesFormatter  $formatter
     * @param  string $styles
     * @return TElement
     */
    public static function multiple(StylesFormatter $formatter, string $styles): StylesFormatter
    {
        $styles = explode(' ', $styles);

        $styles = array_filter($styles, static function ($style): bool {
            return $style !== '';
        });

        foreach ($styles as $style) {
            $formatter = (new self($formatter, $style))->__invoke();
        }

        /** @var TElement $formatter */
        return $formatter;
    }

    /**
     * Converts the given style to a method name.
     *
     * @return StylesFormatter
     */
    public function __invoke(string|int ...$arguments): StylesFormatter
    {
        if (Styles::has($this->style)) {
            return Styles::get($this->style)($this->formatter, ...$arguments);
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

        if (! method_exists($this->formatter, $methodName)) {
            $argument = array_pop($method);

            $arguments[] = is_numeric($argument) ? (int) $argument : (string) $argument;

            return $this->__invoke(...$arguments);
        }

        return $this->formatter->$methodName(...array_reverse($arguments));
    }
}
