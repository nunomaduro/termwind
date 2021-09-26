<?php

declare(strict_types=1);

namespace NunoMaduro\TailCli\Components;

use NunoMaduro\TailCli\Exceptions\StyleNotFound;

/**
 * @internal
 *
 * @template TValue
 */
abstract class Element
{
    /**
     * Creates an element instance.
     *
     * @param TValue $value
     * @param array<string, string|int> $options
     */
    final protected function __construct(protected mixed $value, protected array $options = [])
    {
        // ..
    }

    /**
     * Creates an element instance with the given style.
     *
     * @param  TValue $value
     */
    final public static function fromStyles($value, string $styles): static
    {
        $element = new static($value);

        foreach (explode(' ', $styles) as $style) {
            $method = str_replace('-', ' ', $style);
            $method = ucwords($method);
            $method = str_replace(' ', '', $method);

            if ($style === '') {
                continue;
            }

            if (! method_exists($element, $method)) {
                StyleNotFound::style($style);
            }

            $element->$method();
        }

        return $element;
    }

    /**
     * Adds a background color to the element.
     */
    final public function bg(string $color): static
    {
        return $this->with(['bg' => $color]);
    }

    /**
     * Adds 2 padding left to the element.
     */
    final public function pl2(): static
    {
        return $this->pl(2);
    }

    /**
     * Adds the given padding left to the element.
     */
    final public function pl(int $padding): static
    {
        $value = sprintf('%s%s', str_repeat(' ', $padding), $this->value);

        return new static($value, $this->options);
    }

    /**
     * Adds 2 padding right to the element.
     */
    final public function pr2(): static
    {
        return $this->pr(2);
    }

    /**
     * Adds the given padding right to the element.
     */
    final public function pr(int $padding): static
    {
        $value = sprintf('%s%s', str_repeat(' ', $padding), $this->value);

        return new static($value, $this->options);
    }

    /**
     * Adds a text color to the element.
     */
    final public function textColor(string $color): static
    {
        return $this->with(['fg' => $color]);
    }

    /**
     * Truncates the text of the element.
     */
    final public function truncate(int $limit, string $end = '...'): static
    {
        $limit -= mb_strlen($end);

        if (mb_strwidth($this->value, 'UTF-8') <= $limit) {
            return new static($this->value, $this->options);
        }

        $value = rtrim(mb_strimwidth($this->value, 0, $limit, '', 'UTF-8')).$end;

        return new static($value, $this->options);
    }

    /**
     * Get the string representation of the element.
     */
    final public function toString(): string
    {
        return $this->__toString();
    }

    /**
     * Get the string representation of the element.
     */
    final public function __toString(): string
    {
        if (count($this->options) === 0) {
            return $this->value;
        }

        $options = [];

        foreach ($this->options as $option => $value) {
            $options[] = "$option=$value";
        }

        return sprintf(
            '<%s>%s</>',
            implode(';' ,$options),
            $this->value,
        );
    }

    /**
     * Adds the given options to the element.
     *
     * @param array<string, int|string> $options
     */
    private function with(array $options): static
    {
        return new static(
            $this->value,
            array_merge($this->options, $options)
        );
    }
}
