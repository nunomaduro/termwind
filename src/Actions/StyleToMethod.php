<?php

declare(strict_types=1);

namespace Termwind\Actions;

use Termwind\Exceptions\StyleNotFound;
use Termwind\Repositories\Styles as StyleRepository;
use Termwind\Terminal;
use Termwind\ValueObjects\Styles;

/**
 * @internal
 */
final class StyleToMethod
{
    /**
     * Finds if there is any media query on the style class.
     */
    private const MEDIA_QUERIES_REGEX = "/^(sm|md|lg|xl|2xl)\:(.*)/";

    /**
     * Defines the Media Query Breakpoints.
     */
    public const MEDIA_QUERY_BREAKPOINTS = [
        'sm' => 64,
        'md' => 76,
        'lg' => 102,
        'xl' => 128,
        '2xl' => 153,
    ];

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
        $stylesString = array_merge($styles->defaultStyles(), self::parseStyles($stylesString));
        $stylesString = self::sortStyles($stylesString);

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

        $method = $this->applyMediaQuery($this->style);

        if ($method === '') {
            return $this->styles;
        }

        $method = $this->parseMethod($method, $arguments);

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

    /**
     * Sorts all the styles based on the correct render order.
     *
     * @param  string[]  $styles
     * @return string[]
     */
    private static function sortStyles(array $styles): array
    {
        $keys = array_keys(self::MEDIA_QUERY_BREAKPOINTS);

        usort($styles, function ($a, $b) use ($keys) {
            $existsA = (bool) preg_match(self::MEDIA_QUERIES_REGEX, $a, $matchesA);
            $existsB = (bool) preg_match(self::MEDIA_QUERIES_REGEX, $b, $matchesB);

            if ($existsA && ! $existsB) {
                return 1;
            }

            if ($existsA && array_search($matchesA[1], $keys, true) > array_search($matchesB[1], $keys, true)) {
                return 1;
            }

            return -1;
        });

        return $styles;
    }

    /**
     * Parses the full list of styles into an array with all the methods.
     *
     * @return string[]
     */
    private static function parseStyles(string $str): array
    {
        $str = trim($str);
        $length = mb_strlen($str, 'UTF-8');

        $classes = [];
        $start = 0;
        $inBrackets = false;

        for ($i = 0; $i < $length; $i++) {
            if ($str[$i] === '[') {
                $inBrackets = true;
            } elseif ($str[$i] === ']') {
                $inBrackets = false;
            }

            if ((preg_match('/\s/', $str[$i]) === 1 || $i === $length - 1)
                && ! $inBrackets) {
                $classes[] = trim(substr($str, $start, ($i + 1) - $start));
                $start = $i;
            }
        }

        return $classes;
    }

    /**
     * Parses the full method name into an array of arguments.
     *
     * @param  array<int|string, string|int>  $arguments
     * @return string[]
     */
    private function parseMethod(string $method, array $arguments): array
    {
        $length = mb_strlen($method, 'UTF-8');

        $start = 0;
        $inBrackets = false;
        $items = [];

        for ($i = 0; $i < $length; $i++) {
            if ($method[$i] === '[') {
                $inBrackets = true;
            } elseif ($method[$i] === ']') {
                $inBrackets = false;
            }

            $isLastChar = $i === $length - 1;

            if (($method[$i] === '-' || $isLastChar) && ! $inBrackets) {
                $items[] = trim(substr($method, $start, ($i + ($isLastChar ? 1 : 0)) - $start));
                $start = $i + 1;
            }
        }

        return array_slice($items, 0, count($items) - count($arguments));
    }

    /**
     * Applies the media query if exists.
     */
    private function applyMediaQuery(string $method): string
    {
        preg_match(self::MEDIA_QUERIES_REGEX, $method, $matches);

        if (count($matches ?? []) < 1) {
            return $method;
        }

        [, $size, $method] = $matches;

        if ((new Terminal)->width() >= self::MEDIA_QUERY_BREAKPOINTS[$size]) {
            return $method;
        }

        return '';
    }
}
