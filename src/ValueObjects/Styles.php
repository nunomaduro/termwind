<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Closure;
use Termwind\Actions\StyleToMethod;
use Termwind\Components\Element;
use Termwind\Components\Li;
use Termwind\Components\Ol;
use Termwind\Components\Ul;
use Termwind\Enums\Color;
use Termwind\Exceptions\ColorNotFound;
use Termwind\Exceptions\InvalidStyle;
use Termwind\Repositories\Styles as StyleRepository;
use function Termwind\terminal;

/**
 * @internal
 */
final class Styles
{
    /** @var array<int, string> */
    private array $styles = [];
    private ?Element $element = null;

    /**
     * Creates a Style formatter instance.
     *
     * @param  array<string, mixed>  $properties
     * @param  array<string, Closure(string, array<string, string|int>): string>  $textModifiers
     * @param  array<string, Closure(string): string>  $styleModifiers
     * @param  string[]  $defaultStyles
     */
    final public function __construct(
        private array $properties = [
            'colors' => [],
            'options' => [],
            'isFirstChild' => false,
        ],
        private array $textModifiers = [],
        private array $styleModifiers = [],
        private array $defaultStyles = []
    ) {
    }

    /**
     * @param  Element  $element
     * @return $this
     */
    public function setElement(Element $element): self
    {
        $this->element = $element;

        return $this;
    }

    /**
     * Gets default styles.
     *
     * @return string[]
     */
    public function defaultStyles(): array
    {
        return $this->defaultStyles;
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
     * Sets the element's style properties.
     *
     * @param  array<string, mixed>  $properties
     */
    public function setProperties(array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Sets the styles to the element.
     */
    final public function setStyle(string $style): self
    {
        $this->styles = array_unique(array_merge($this->styles, [$style]));

        return $this;
    }

    /**
     * Checks if the element has the style.
     */
    final public function hasStyle(string $style): bool
    {
        return in_array($style, $this->styles, true);
    }

    /**
     * Adds a style to the element.
     */
    final public function addStyle(string $style): self
    {
        return StyleToMethod::multiple($this, $style);
    }

    /**
     * Checks if formatter has styles.
     */
    final public function hasInheritableStyles(): bool
    {
        return ($this->properties['colors']['bg'] ?? []) !== []
            || ($this->properties['colors']['fg'] ?? []) !== []
            || ($this->properties['options'] ?? []) !== []
            || ($this->properties['href'] ?? []) !== [];
    }

    /**
     * Inherit styles from given Styles object.
     */
    final public function inheritFromStyles(Styles $styles): self
    {
        foreach (['bg', 'fg'] as $colorType) {
            $value = (array) ($this->properties['colors'][$colorType] ?? []);
            $parentValue = (array) ($styles->properties['colors'][$colorType] ?? []);

            if ($value === [] && $parentValue !== []) {
                $this->properties['colors'][$colorType] = $styles->properties['colors'][$colorType];
            }
        }

        return $this;
    }

    /**
     * Adds a background color to the element.
     */
    final public function bg(string $color, int $variant = 0): self
    {
        return $this->with(['colors' => [
            'bg' => $this->getColorVariant($color, $variant),
        ]]);
    }

    /**
     * Adds a bold style to the element.
     */
    final public function fontBold(): self
    {
        return $this->with(['options' => [
            'bold' => true,
        ]]);
    }

    /**
     * Adds a bold style to the element.
     */
    final public function strong(): self
    {
        $this->styleModifiers[__METHOD__] = static fn ($text): string => sprintf("\e[1m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds an italic style to the element.
     */
    final public function italic(): self
    {
        $this->styleModifiers[__METHOD__] = static fn ($text): string => sprintf("\e[3m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds an underline style.
     */
    final public function underline(): self
    {
        $this->styleModifiers[__METHOD__] = static fn ($text): string => sprintf("\e[4m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds the given margin left to the element.
     */
    final public function ml(int $margin): self
    {
        return $this->with(['styles' => [
            'ml' => $margin,
        ]]);
    }

    /**
     * Adds the given margin right to the element.
     */
    final public function mr(int $margin): self
    {
        return $this->with(['styles' => [
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given margin bottom to the element.
     */
    final public function mb(int $margin): self
    {
        return $this->with(['styles' => [
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin top to the element.
     */
    final public function mt(int $margin): self
    {
        return $this->with(['styles' => [
            'mt' => $margin,
        ]]);
    }

    /**
     * Adds the given horizontal margin to the element.
     */
    final public function mx(int $margin): self
    {
        return $this->with(['styles' => [
            'ml' => $margin,
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given vertical margin to the element.
     */
    final public function my(int $margin): self
    {
        return $this->with(['styles' => [
            'mt' => $margin,
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin to the element.
     */
    final public function m(int $margin): self
    {
        return $this->my($margin)->mx($margin);
    }

    /**
     * Adds the given padding left to the element.
     */
    final public function pl(int $padding): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => sprintf(
            '%s%s',
            str_repeat(' ', $padding),
            $text
        );

        return $this;
    }

    /**
     * Adds the given padding right.
     */
    final public function pr(int $padding): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => sprintf(
            '%s%s',
            $text,
            str_repeat(' ', $padding)
        );

        return $this;
    }

    /**
     * Adds the given horizontal padding.
     */
    final public function px(int $padding): self
    {
        return $this->p($padding);
    }

    /**
     * Adds the given padding.
     */
    final public function p(int $padding): self
    {
        return $this->pl($padding)->pr($padding);
    }

    /**
     * Adds a text alignment or color to the element.
     */
    final public function text(string $value, int $variant = 0): self
    {
        if (in_array($value, ['left', 'right', 'center'], true)) {
            return $this->with(['styles' => [
                'text-align' => $value,
            ]]);
        }

        return $this->with(['colors' => [
            'fg' => $this->getColorVariant($value, $variant),
        ]]);
    }

    /**
     * Truncates the text of the element.
     */
    final public function truncate(int $limit, string $end = '...'): self
    {
        $this->textModifiers[__METHOD__] = static function ($text) use ($limit, $end): string {
            $limit -= mb_strwidth($end, 'UTF-8');

            if (mb_strwidth($text, 'UTF-8') <= $limit) {
                return $text;
            }

            return rtrim(mb_strimwidth($text, 0, $limit, '', 'UTF-8')).$end;
        };

        return $this;
    }

    /**
     * Forces the width of the element.
     */
    final public function w(int $content): self
    {
        $this->textModifiers[__METHOD__] = static function ($text, $styles) use ($content): string {
            $content -= ($styles['ml'] ?? 0) + ($styles['mr'] ?? 0);
            $length = mb_strlen(preg_replace("/\<[\w=#\/\;,]+\>/", '', $text), 'UTF-8');

            if ($length <= $content) {
                $space = $content - $length;

                return match ($styles['text-align'] ?? '') {
                    'right' => str_repeat(' ', $space).$text,
                    'center' => str_repeat(' ', (int) floor($space / 2)).$text.str_repeat(' ', (int) ceil($space / 2)),
                    default => $text.str_repeat(' ', $space),
                };
            }

            return rtrim(mb_strimwidth($text, 0, $content, '', 'UTF-8'));
        };

        return $this;
    }

    /**
     * Forces the element width to the full width of the terminal.
     */
    final public function wFull(): static
    {
        return $this->w(terminal()->width());
    }

    /**
     * Makes the element's content uppercase.
     */
    final public function uppercase(): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => mb_strtoupper($text, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => mb_strtolower($text, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content capitalize.
     */
    final public function capitalize(): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content in snakecase.
     */
    final public function snakecase(): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => mb_strtolower(
            (string) preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $text),
            'UTF-8'
        );

        return $this;
    }

    /**
     * Makes the element's content with a line through.
     */
    final public function lineThrough(): self
    {
        $this->styleModifiers[__METHOD__] = static fn ($text): string => sprintf("\e[9m%s\e[0m", $text);

        return $this;
    }

    /**
     * Makes the element's content invisible.
     */
    final public function invisible(): self
    {
        $this->styleModifiers[__METHOD__] = static fn ($text): string => sprintf("\e[8m%s\e[0m", $text);

        return $this;
    }

    /**
     * Makes a line break before the element's content.
     */
    final public function block(): self
    {
        return $this->with(['styles' => [
            'display' => 'block',
        ]]);
    }

    /**
     * Prepends text to the content.
     */
    final public function prepend(string $string): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => $string.$text;

        return $this;
    }

    /**
     * Appends text to the content.
     */
    final public function append(string $string): self
    {
        $this->textModifiers[__METHOD__] = static fn ($text): string => $text.$string;

        return $this;
    }

    /**
     * Prepends the list style type to the content.
     */
    final public function list(string $type, int $index = 0): self
    {
        if (! $this->element instanceof Ul && ! $this->element instanceof Ol && ! $this->element instanceof Li) {
            throw new InvalidStyle(sprintf(
                'Style list-none cannot be used with %s',
                $this->element !== null ? $this->element::class : 'unknown element'
            ));
        }

        if (! $this->element instanceof Li) {
            return $this;
        }

        return match ($type) {
            'square' => $this->prepend('▪ '),
            'disc' => $this->prepend('• '),
            'decimal' => $this->prepend(sprintf('%d. ', $index)),
            default => $this,
        };
    }

    /**
     * Adds the given properties to the element.
     *
     * @param  array<string, mixed>  $properties
     */
    public function with(array $properties): self
    {
        $this->properties = array_replace_recursive($this->properties, $properties);

        return $this;
    }

    /**
     * Sets the href property to the element.
     */
    final public function href(string $href): self
    {
        return $this->with(['href' => array_filter([$href])]);
    }

    /**
     * Formats a given string.
     */
    final public function format(string $content): string
    {
        $display = $this->properties['styles']['display'] ?? 'inline';

        /** @var bool $isFirstChild */
        $isFirstChild = $this->properties['isFirstChild'] ?? false;

        foreach ($this->textModifiers as $modifier) {
            $content = $modifier($content, $this->properties['styles'] ?? []);
        }

        foreach ($this->styleModifiers as $modifier) {
            $content = $modifier($content);
        }

        return sprintf(
            $this->getFormatString(),
            $display === 'block' && ! $isFirstChild ? "\n" : '',
            str_repeat("\n", (int) ($this->properties['styles']['mt'] ?? 0)),
            str_repeat(' ', (int) ($this->properties['styles']['ml'] ?? 0)),
            $content,
            str_repeat(' ', (int) ($this->properties['styles']['mr'] ?? 0)),
            str_repeat("\n", (int) ($this->properties['styles']['mb'] ?? 0)),
        );
    }

    /**
     * Get the format string including required styles.
     */
    private function getFormatString(): string
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

        $options = array_keys($this->properties['options'] ?? []);
        if ($options !== []) {
            $styles[] = 'options='.implode(',', $options);
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
        if ($variant > 0) {
            $color .= '-'.$variant;
        }

        if (StyleRepository::has($color)) {
            return StyleRepository::get($color)->getColor();
        }

        $colorConstant = mb_strtoupper(str_replace('-', '_', $color), 'UTF-8');

        if (! defined(Color::class."::$colorConstant")) {
            throw new ColorNotFound($colorConstant);
        }

        return constant(Color::class."::$colorConstant");
    }
}
