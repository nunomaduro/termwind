<?php

declare(strict_types=1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\StyleToMethod;
use Termwind\Enums\Color;
use Termwind\Exceptions\ColorNotFound;
use Termwind\Exceptions\InvalidStyle;
use function Termwind\terminal;

/**
 * @internal
 */
abstract class Element
{
    /**
     * @var array<int, string>
     */
    public $defaultStyles = [];

    /**
     * Creates an element instance.
     *
     * @param  array<string, mixed>  $properties
     * @param  array<int, string>  $styles
     */
    final public function __construct(
        protected OutputInterface $output,
        protected string $content,
        protected array $properties = [
            'colors' => [],
            'options' => [],
            'isFirstChild' => false,
        ],
        protected array $styles = [],
    ) {
    }

    /**
     * Creates an element instance with the given styles.
     *
     * @param  array<string, mixed>  $properties
     * @param  array<int, string>  $elementStyles
     */
    final public static function fromStyles(OutputInterface $output, string $content, string $styles, array $properties = [], array $elementStyles = []): static
    {
        $element = new static($output, $content, $properties, $elementStyles);

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

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Adds an italic style to the element.
     */
    final public function italic(): static
    {
        $content = sprintf("\e[3m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Adds an underline style to the element.
     */
    final public function underline(): static
    {
        $content = sprintf("\e[4m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties, $this->styles);
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

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Adds the given padding right to the element.
     */
    final public function pr(int $padding): static
    {
        $content = sprintf('%s%s', $this->content, str_repeat(' ', $padding));

        return new static($this->output, $content, $this->properties, $this->styles);
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
            return new static($this->output, $this->content, $this->properties, $this->styles);
        }

        $content = rtrim(mb_strimwidth($this->content, 0, $limit, '', 'UTF-8')).$end;

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Forces the width of the element.
     */
    final public function width(int $content): static
    {
        $length = mb_strlen($this->content, 'UTF-8');

        if ($length <= $content) {
            $content = $this->content.str_repeat(' ', $content - $length);

            return new static($this->output, $content, $this->properties, $this->styles);
        }

        $content = rtrim(mb_strimwidth($this->content, 0, $content, '', 'UTF-8'));

        return new static($this->output, $content, $this->properties, $this->styles);
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
        $content = $this->applyModifier(
            $this->content,
            fn ($text) => mb_strtoupper($text, 'UTF-8')
        );

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): static
    {
        $content = $this->applyModifier(
            $this->content,
            fn ($text) => mb_strtolower($text, 'UTF-8')
        );

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Makes the element's content capitalize.
     */
    final public function capitalize(): static
    {
        $content = $this->applyModifier(
            $this->content,
            fn ($text) => mb_convert_case($text, MB_CASE_TITLE, 'UTF-8')
        );

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Makes the element's content in snakecase.
     */
    final public function snakecase(): static
    {
        $content = $this->applyModifier(
            $this->content,
            fn ($text) => mb_strtolower(
                (string) preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $text),
                'UTF-8'
            )
        );

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Makes the element's content with a line through.
     */
    final public function lineThrough(): static
    {
        $content = sprintf("\e[9m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Makes the element's content invisible.
     */
    final public function invisible(): static
    {
        $content = sprintf("\e[8m%s\e[0m", $this->content);

        return new static($this->output, $content, $this->properties, $this->styles);
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

        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Prepends the list style type to the content.
     */
    final public function list(string $type, int $index = 0): static
    {
        if (! $this instanceof Ul && ! $this instanceof Ol && ! $this instanceof Li) {
            throw new InvalidStyle(sprintf('Style list-none cannot be used with %s', static::class));
        }

        if (! $this instanceof Li) {
            return new static($this->output, $this->content, $this->properties, $this->styles);
        }

        return match ($type) {
            'square' => $this->prepend('▪ '),
            'disc' => $this->prepend('• '),
            'decimal' => $this->prepend(sprintf('%d. ', $index)),
            default => new static($this->output, $this->content, $this->properties, $this->styles)
        };
    }

    /**
     * Sets the styles to the element.
     */
    final public function setStyle(string $style): static
    {
        $styles = array_unique(array_merge($this->styles, [$style]));

        return new static($this->output, $this->content, $this->properties, $styles);
    }

    /**
     * Adds a style to the element.
     */
    final public function addStyle(string $style): static
    {
        return static::fromStyles($this->output, $this->content, $style, $this->properties, $this->styles);
    }

    /**
     * Checks if the element has the style.
     */
    final public function hasStyle(string $style): bool
    {
        return in_array($style, $this->styles, true);
    }

    /**
     * Sets the content of the element.
     */
    final public function setContent(string $content): static
    {
        return new static($this->output, $content, $this->properties, $this->styles);
    }

    /**
     * Renders the string representation of the element on the output.
     */
    final public function render(): void
    {
        $this->output->writeln($this->toString());
    }

    /**
     * Gets the element's style properties.
     *
     * @return array<string, mixed>
     */
    final public function getProperties(): array
    {
        return $this->properties;
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
        $properties = array_replace_recursive($this->properties, $properties);

        return new static(
            $this->output,
            $this->content,
            $properties,
            $this->styles,
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
     * Applies the modifier to the content ignoring all the escape codes.
     */
    private function applyModifier(string $content, \Closure $callback): string
    {
        preg_match_all(
            '/(?:\\e\[\dm)+(?<match>[^\\e]+)(?:\\e\[\dm)+/',
            $content,
            $matches,
            PREG_OFFSET_CAPTURE
        );

        $matches = $matches['match'][0] ?? null;

        if (is_null($matches)) {
            return $callback($content);
        }

        [$text, $index] = $matches;

        return substr_replace($content, $callback($text), $index, mb_strlen($text));
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
