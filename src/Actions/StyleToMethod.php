<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Contracts\Renderable;
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
     * @param  Renderable  $renderable
     */
    public function __construct(
        private Renderable $renderable,
        private string $style,
    ) {
        // ..
    }

    /**
     * Applies multiple styles to the given renderable.
     *
     * @template TRenderable of Renderable
     *
     * @param  TRenderable $renderable
     * @return TRenderable
     */
    public static function multiple(Renderable $renderable, string $styles): Renderable
    {
        $styles = explode(' ', $styles);

        $styles = array_filter($styles, static function ($style): bool {
            return $style !== '';
        });

        foreach ($styles as $style) {
            $renderable = (new self($renderable, $style))->__invoke();
        }

        /** @var TRenderable $renderable */
        return $renderable;
    }

    /**
     * Converts the given style to a method name.
     *
     * @return Renderable
     */
    public function __invoke(string|int ...$arguments): Renderable
    {
        if (Styles::has($this->style)) {
            $renderable = Styles::get($this->style)($this->renderable, ...$arguments);

            return $renderable;
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

        if (! method_exists($this->renderable, $methodName)) {
            $argument = array_pop($method);

            $arguments[] = is_numeric($argument) ? (int) $argument : (string) $argument;

            return $this->__invoke(...$arguments);
        }

        return $this->renderable->$methodName(...$arguments);
    }
}
