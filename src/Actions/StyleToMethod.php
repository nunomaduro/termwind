<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Exceptions\StyleNotFound;
use Termwind\Repositories\Styles as StyleRepository;
use Termwind\ValueObjects\Styles;

/**
 * @internal
 */
final class StyleToMethod
{
    /**
     * Creates a new action instance.
     */
    public function __construct(
        private Styles $styles,
        private string $style,
    ) {
        // ..
    }

    /**
     * Applies multiple styles to the given styles.
     */
    public static function multiple(Styles $styles, string $stylesString): Styles
    {
        $stylesString = array_merge($styles->defaultStyles(), explode(' ', $stylesString));

        $stylesString = array_filter($stylesString, static function ($style): bool {
            return $style !== '';
        });

        foreach ($stylesString as $style) {
            $styles = (new self($styles, $style))->__invoke();
        }

        return $styles;
    }

    /**
     * Converts the given style to a method name.
     *
     * @return Styles
     */
    public function __invoke(string|int ...$arguments): Styles
    {
        if (StyleRepository::has($this->style)) {
            return StyleRepository::get($this->style)($this->styles, ...$arguments);
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

        if (! method_exists($this->styles, $methodName)) {
            $argument = array_pop($method);

            $arguments[] = is_numeric($argument) ? (int) $argument : (string) $argument;

            return $this->__invoke(...$arguments);
        }

        return $this->styles
            ->setStyle($this->style)
            ->$methodName(...array_reverse($arguments));
    }
}
