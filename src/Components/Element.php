<?php

declare(strict_types=1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\StyleToMethod;

/**
 * @internal
 */
abstract class Element
{
    /**
     * Creates an element instance.
     *
     * @param  string  $value
     * @param  array<string, mixed>  $properties
     */
    final public function __construct(
        protected OutputInterface $output,
        protected string $value,
        protected array $properties = [
            'colors' => [
                'bg' => 'default',
            ],
            'options' => [],
        ])
    {
        // ..
    }

    /**
     * Creates an element instance with the given styles.
     */
    final public static function fromStyles(OutputInterface $output, string $value, string $styles): static
    {
        $element = new static($output, $value);

        return StyleToMethod::multiple($element, $styles);
    }

    /**
     * Adds a background color to the element.
     */
    final public function bg(string $color): static
    {
        return $this->with(['colors' => ['bg' => $color]]);
    }

    /**
     * Adds a bold style to the element.
     */
    final public function fontBold(): static
    {
        return $this->with(['options' => ['bold']]);
    }

    /**
     * Adds an underline style to the element.
     */
    final public function underline(): static
    {
        return $this->with(['options' => ['underscore']]);
    }

    /**
     * Adds the given margin left to the element.
     */
    final public function ml(int $margin): static
    {
        return $this->with(['styles' => [
            'ml' => $margin,
        ]]);
    }

    /**
     * Adds the given margin right to the element.
     */
    final public function mr(int $margin): static
    {
        return $this->with(['styles' => [
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given horizontal margin to the element.
     */
    final public function mx(int $margin): static
    {
        return $this->with(['styles' => [
            'ml' => $margin,
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given padding left to the element.
     */
    final public function pl(int $padding): static
    {
        $value = sprintf('%s%s', str_repeat(' ', $padding), $this->value);

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Adds the given padding right to the element.
     */
    final public function pr(int $padding): static
    {
        $value = sprintf('%s%s', $this->value, str_repeat(' ', $padding));

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Adds the given horizontal padding to the element.
     */
    final public function px(int $padding): static
    {
        return $this->p($padding);
    }

    /**
     * Adds the given padding to the element.
     */
    final public function p(int $padding): static
    {
        return $this->pl($padding)->pr($padding);
    }

    /**
     * Adds a text color to the element.
     */
    final public function textColor(string $color): static
    {
        return $this->with(['colors' => [
            'fg' => $color,
        ]]);
    }

    /**
     * Truncates the text of the element.
     */
    final public function truncate(int $limit, string $end = '...'): static
    {
        $limit -= mb_strwidth($end, 'UTF-8');

        if (mb_strwidth($this->value, 'UTF-8') <= $limit) {
            return new static($this->output, $this->value, $this->properties);
        }

        $value = rtrim(mb_strimwidth($this->value, 0, $limit, '', 'UTF-8')).$end;

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Forces the width of the element.
     */
    final public function width(int $value): static
    {
        $length = mb_strlen($this->value, 'UTF-8');

        if ($length <= $value) {
            $value = $this->value.str_repeat(' ', $value - $length);

            return new static($this->output, $value, $this->properties);
        }

        $value = rtrim(mb_strimwidth($this->value, 0, $value, '', 'UTF-8'));

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Makes the element's content uppercase.
     */
    final public function uppercase(): static
    {
        $value = mb_strtoupper($this->value, 'UTF-8');

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): static
    {
        $value = mb_strtolower($this->value, 'UTF-8');

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Makes the element's content capitalize.
     */
    final public function capitalize(): static
    {
        $value = mb_convert_case($this->value, MB_CASE_TITLE, 'UTF-8');

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Makes the element's content in snakecase.
     */
    final public function snakecase(): static
    {
        $value = mb_strtolower(
            (string) preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $this->value),
            'UTF-8'
        );

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Makes the element's content with a line through.
     */
    final public function lineThrough(): static
    {
        $value = sprintf("\e[9m%s\e[0m", $this->value);

        return new static($this->output, $value, $this->properties);
    }

    /**
     * Renders the string representation of the element on the output.
     */
    final public function render(): void
    {
        $this->output->write($this->toString());
    }

    /**
     * Get the string representation of the element.
     */
    final public function toString(): string
    {
        $colors = [];

        foreach ($this->properties['colors'] as $option => $value) {
            if (in_array($option, ['fg', 'bg'], true)) {
                $value = is_array($value) ? array_pop($value) : $value;

                $colors[] = "$option=$value";
            }
        }

        /** @var string $href */
        $href = $this->properties['href'] ?? '';

        $options = [];

        foreach ($this->properties['options'] as $option) {
            $options[] = $option;
        }

        return sprintf(
            '%s<%s%s;options=%s>%s</>%s',
            str_repeat(' ', (int) ($this->properties['styles']['ml'] ?? 0)),
            $href === '' ? '' : sprintf('href=%s;', $href),
            implode(';', $colors),
            implode(',', $options),
            $this->value,
            str_repeat(' ', (int) ($this->properties['styles']['mr'] ?? 0)),
        );
    }

    /**
     * Get the string representation of the element.
     */
    final public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Adds the given properties to the element.
     *
     * @param  array<string, array<int|string, int|string>>  $properties
     */
    private function with(array $properties): static
    {
        $properties = array_merge_recursive($this->properties, $properties);

        return new static(
            $this->output,
            $this->value,
            $properties,
        );
    }
}
