<?php

declare(strict_types=1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\StyleToMethod;
use Termwind\Enums\Color;
use Termwind\Exceptions\ColorNotFound;
use function Termwind\terminal;

/**
 * @internal
 */
abstract class Element
{

    /**
     * Creates an element instance.
     *
     * @param  array<string, mixed>  $properties
     */
    final public function __construct(
        protected OutputInterface $output,
        protected string $content,
        protected array $properties = [
            'colors' => [],
            'options' => [],
            'isFirstChild' => false,
        ])
    {
    }

    /**
     * Creates an element instance with the given styles.
     */
    final public static function fromStyles(OutputInterface $output, string $content, string $styles, bool $isFirstChild = false): static
    {
        $element = new static($output, $content, [
            'isFirstChild' => $isFirstChild,
        ]);

        return StyleToMethod::multiple($element, $styles);
    }

    /**
     * Adds a background color to the element.
     */
    final public function bg(string $color, int $variant = 0): static
    {
        if ($variant > 0) {
            $color = $this->getColorVariant($color, $variant);
        }

        return $this->with(['colors' => ['bg' => $color]]);
    }

    /**
     * Adds a bold style to the element.
     */
    final public function fontBold(): static
    {
        $content = sprintf("\e[1m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Adds an italic style to the element.
     */
    final public function italic(): static
    {
        $content = sprintf("\e[3m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Adds an underline style to the element.
     */
    final public function underline(): static
    {
        $content = sprintf("\e[4m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties);
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
     * Adds the given margin bottom to the element.
     */
    final public function mb(int $margin): static
    {
        return $this->with(['styles' => [
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin top to the element.
     */
    final public function mt(int $margin): static
    {
        return $this->with(['styles' => [
            'mt' => $margin,
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
     * Adds the given vertical margin to the element.
     */
    final public function my(int $margin): static
    {
        return $this->with(['styles' => [
            'mt' => $margin,
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin to the element.
     */
    final public function m(int $margin): static
    {
        return $this->my($margin)->mx($margin);
    }

    /**
     * Adds the given padding left to the element.
     */
    final public function pl(int $padding): static
    {
        $content = sprintf('%s%s', str_repeat(' ', $padding), $this->content);

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Adds the given padding right to the element.
     */
    final public function pr(int $padding): static
    {
        $content = sprintf('%s%s', $this->content, str_repeat(' ', $padding));

        return new static($this->output, $content, $this->properties);
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
    final public function textColor(string $color, int $variant = 0): static
    {
        if ($variant > 0) {
            $color = $this->getColorVariant($color, $variant);
        }

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

        if (mb_strwidth($this->content, 'UTF-8') <= $limit) {
            return new static($this->output, $this->content, $this->properties);
        }

        $content = rtrim(mb_strimwidth($this->content, 0, $limit, '', 'UTF-8')).$end;

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Forces the width of the element.
     */
    final public function width(int $content): static
    {
        $length = mb_strlen($this->content, 'UTF-8');

        if ($length <= $content) {
            $content = $this->content.str_repeat(' ', $content - $length);

            return new static($this->output, $content, $this->properties);
        }

        $content = rtrim(mb_strimwidth($this->content, 0, $content, '', 'UTF-8'));

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Forces the element width to the full width of the terminal.
     */
    final public function wFull(): static
    {
        return $this->width(terminal()->width());
    }

    /**
     * Makes the element's content uppercase.
     */
    final public function uppercase(): static
    {
        $content = mb_strtoupper($this->content, 'UTF-8');

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): static
    {
        $content = mb_strtolower($this->content, 'UTF-8');

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes the element's content capitalize.
     */
    final public function capitalize(): static
    {
        $content = mb_convert_case($this->content, MB_CASE_TITLE, 'UTF-8');

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes the element's content in snakecase.
     */
    final public function snakecase(): static
    {
        $content = mb_strtolower(
            (string) preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $this->content),
            'UTF-8'
        );

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes the element's content with a line through.
     */
    final public function lineThrough(): static
    {
        $content = sprintf("\e[9m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes the element's content invisible.
     */
    final public function invisible(): static
    {
        $content = sprintf("\e[8m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Makes a line break before the element's content.
     */
    final public function block(): static
    {
        return $this->with(['styles' => [
            'display' => 'block',
        ]]);
    }

    /**
     * Prepends text to the content.
     */
    final public function prepend(string $text): static
    {
        $content = $text.$this->content;

        return new static($this->output, $content, $this->properties);
    }

    /**
     * Renders the string representation of the element on the output.
     */
    final public function render(): void
    {
        $this->output->writeln($this->toString());
    }

    /**
     * Get the string representation of the element.
     */
    public function toString(): string
    {
        $display = $this->properties['styles']['display'] ?? 'inline';

        /** @var bool $isFirstChild */
        $isFirstChild = $this->properties['isFirstChild'] ?? false;

        return sprintf(
            $this->getContentFormatString(),
            $display === 'block' && ! $isFirstChild ? "\n" : '',
            str_repeat("\n", (int) ($this->properties['styles']['mt'] ?? 0)),
            str_repeat(' ', (int) ($this->properties['styles']['ml'] ?? 0)),
            $this->content,
            str_repeat(' ', (int) ($this->properties['styles']['mr'] ?? 0)),
            str_repeat("\n", (int) ($this->properties['styles']['mb'] ?? 0)),
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
    public function with(array $properties): static
    {
        $properties = array_merge_recursive($this->properties, $properties);

        return new static(
            $this->output,
            $this->content,
            $properties,
        );
    }

    /**
     * Get the format string including required styles.
     */
    private function getContentFormatString(): string
    {
        $styles = [];

        /** @var array<int, string> $href */
        $href = $this->properties['href'] ?? [];
        if ($href !== []) {
            $styles[] = sprintf('href=%s', array_pop($href));
        }

        /** @var array<int, string> $href */
        $colors = $this->properties['colors'] ?? [];

        foreach ($colors as $option => $content) {
            if (in_array($option, ['fg', 'bg'], true)) {
                $content = is_array($content) ? array_pop($content) : $content;

                $styles[] = "$option=$content";
            }
        }

        // If there are no styles we don't need extra tags
        if ($styles === []) {
            return '%s%s%s%s%s%s';
        }

        return '%s%s%s<'.implode(';', $styles).'>%s</>%s%s';
    }

    /**
     * Get the constant variant color from Color class.
     */
    private function getColorVariant(string $color, int $variant): string
    {
        $colorConstant = mb_strtoupper($color.'_'.$variant, 'UTF-8');

        if (! defined(Color::class."::$colorConstant")) {
            throw new ColorNotFound($colorConstant);
        }

        return constant(Color::class."::$colorConstant");
    }
}
