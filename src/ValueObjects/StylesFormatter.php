<?php

declare(strict_types=1);

namespace Termwind\ValueObjects;

use Termwind\Actions\StyleToMethod;
use Termwind\Enums\Color;
use Termwind\Exceptions\ColorNotFound;
use function Termwind\terminal;

/**
 * @internal
 */
final class StylesFormatter
{
    final public function __construct(
        protected array $properties = [
            'colors' => [],
            'options' => [],
        ],
        protected array $textModifiers = [],
        protected array $styleModifiers = []
    )
    {
    }

    /**
     * Creates an instance with the given styles.
     */
    final public static function fromStyles(string $styles): self
    {
        $formatter = new self();

        return StyleToMethod::multiple($formatter, $styles);
    }

    /**
     * Checks if formatter has styles
     */
    final public function hasStyles(): bool
    {
        return !empty($this->properties['colors']['bg'])
            || !empty($this->properties['colors']['fg'])
            || !empty($this->properties['options']);
    }

    /**
     * Inherit styles from given string
     */
    final public function inheritFromStyles(StylesFormatter $formatter): self
    {
        if ($this->hasStyles()) {
            if (!isset($this->properties['colors']['bg']) && isset($formatter->properties['colors']['bg'])) {
                $this->properties['colors']['bg'] = $formatter->properties['colors']['bg'];
            }

            if (!isset($this->properties['colors']['fg']) && isset($formatter->properties['colors']['fg'])) {
                $this->properties['colors']['fg'] = $formatter->properties['colors']['fg'];
            }
        }

        return $this;
    }

    /**
     * Adds a background color.
     */
    final public function bg(string $color, int $variant = 0): self
    {
        if ($variant > 0) {
            $color = $this->getColorVariant($color, $variant);
        }

        return $this->with(['colors' => ['bg' => $color]]);
    }

    /**
     * Adds a bold style.
     */
    final public function fontBold(): self
    {
        $this->styleModifiers[__METHOD__] = static fn($text) => sprintf("\e[1m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds an italic style.
     */
    final public function italic(): self
    {
        $this->styleModifiers[__METHOD__] = static fn($text) => sprintf("\e[3m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds an underline style.
     */
    final public function underline(): self
    {
        $this->styleModifiers[__METHOD__] = static fn($text) => sprintf("\e[4m%s\e[0m", $text);

        return $this;
    }

    /**
     * Adds the given margin left.
     */
    final public function ml(int $margin): self
    {
        return $this->with(['styles' => [
            'ml' => $margin,
        ]]);
    }

    /**
     * Adds the given margin right.
     */
    final public function mr(int $margin): self
    {
        return $this->with(['styles' => [
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given margin bottom.
     */
    final public function mb(int $margin): self
    {
        return $this->with(['styles' => [
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin top.
     */
    final public function mt(int $margin): self
    {
        return $this->with(['styles' => [
            'mt' => $margin,
        ]]);
    }

    /**
     * Adds the given horizontal margin.
     */
    final public function mx(int $margin): self
    {
        return $this->with(['styles' => [
            'ml' => $margin,
            'mr' => $margin,
        ]]);
    }

    /**
     * Adds the given vertical margin.
     */
    final public function my(int $margin): self
    {
        return $this->with(['styles' => [
            'mt' => $margin,
            'mb' => $margin,
        ]]);
    }

    /**
     * Adds the given margin.
     */
    final public function m(int $margin): self
    {
        return $this->my($margin)->mx($margin);
    }

    /**
     * Adds the given padding left.
     */
    final public function pl(int $padding): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => sprintf('%s%s', str_repeat(' ', $padding), $text);

        return $this;
    }

    /**
     * Adds the given padding right.
     */
    final public function pr(int $padding): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => sprintf('%s%s', $text, str_repeat(' ', $padding));

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
     * Adds a text color.
     */
    final public function textColor(string $color, int $variant = 0): self
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
    final public function truncate(int $limit, string $end = '...'): self
    {
        $this->textModifiers[__METHOD__] = static function ($text) use ($limit, $end) {
            $limit -= mb_strwidth($end, 'UTF-8');

            if (mb_strwidth($text, 'UTF-8') <= $limit) {
                return $text;
            }

            return rtrim(mb_strimwidth($text, 0, $limit, '', 'UTF-8')) . $end;
        };


        return $this;
    }

    /**
     * Forces the width of the element.
     */
    final public function width(int $content): self
    {
        $this->textModifiers[__METHOD__] = static function ($text) use ($content) {
            $length = mb_strlen($text, 'UTF-8');

            if ($length <= $content) {
                return $text . str_repeat(' ', $content - $length);
            }

            return rtrim(mb_strimwidth($text, 0, $content, '', 'UTF-8'));
        };

        return $this;
    }

    /**
     * Forces the element width to the full width of the terminal.
     */
    final public function wFull(): self
    {
        return $this->width(terminal()->width());
    }

    /**
     * Makes the element's content uppercase.
     */
    final public function uppercase(): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => mb_strtoupper($text, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => mb_strtolower($text, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content capitalize.
     */
    final public function capitalize(): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');

        return $this;
    }

    /**
     * Makes the element's content in snakecase.
     */
    final public function snakecase(): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => mb_strtolower(
            (string)preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $text),
            'UTF-8'
        );

        return $this;
    }

    /**
     * Makes the element's content with a line through.
     */
    final public function lineThrough(): self
    {
        $this->styleModifiers[__METHOD__] = static fn($text) => sprintf("\e[9m%s\e[0m", $text);

        return $this;
    }

    /**
     * Makes the element's content invisible.
     */
    final public function invisible(): self
    {
        $this->styleModifiers[__METHOD__] = static fn($text) => sprintf("\e[8m%s\e[0m", $text);

        return $this;
    }

    /**
     * Prepends text to the content.
     */
    final public function prepend(string $string): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => $string.$text;

        return $this;
    }

    /**
     * Appends text to the content.
     */
    final public function append(string $string): self
    {
        $this->textModifiers[__METHOD__] = static fn($text) => $text.$string;

        return $this;
    }

    /**
     * Formats a given string
     */
    final public function format(string $content): string
    {
        foreach ($this->textModifiers as $modifier) {
            $content = $modifier($content);
        }

        foreach ($this->styleModifiers as $modifier) {
            $content = $modifier($content);
        }

        return sprintf(
            $this->getFormatString(),
            str_repeat("\n", (int)($this->properties['styles']['mt'] ?? 0)),
            str_repeat(' ', (int)($this->properties['styles']['ml'] ?? 0)),
            $content,
            str_repeat(' ', (int)($this->properties['styles']['mr'] ?? 0)),
            str_repeat("\n", (int)($this->properties['styles']['mb'] ?? 0)),
        );
    }

    /**
     * Adds the given properties.
     *
     * @param array<string, array<int|string, int|string>> $properties
     */
    public function with(array $properties): self
    {
        $this->properties = array_merge_recursive($this->properties, $properties);

        return $this;
    }

    /**
     * Get the format string including required styles.
     */
    private function getFormatString(): string
    {
        $styles = [];

        foreach ($this->properties['options'] as $key => $option) {
            if (!empty($option)) {
                $styles[] = sprintf('%s=%s', $key, $option);
            }
        }

        foreach ($this->properties['colors'] as $option => $content) {
            if (in_array($option, ['fg', 'bg'], true)) {
                $content = is_array($content) ? array_pop($content) : $content;

                // Skip default color
                if ($content === 'default') {
                    continue;
                }

                $styles[] = "$option=$content";
            }
        }

        // If there are no styles we don't need extra tags
        if ($styles === []) {
            return '%s%s%s%s%s';
        }

        return '%s%s<' . implode(';', $styles) . '>%s</>%s%s';
    }

    /**
     * Get the constant variant color from Color class.
     */
    private function getColorVariant(string $color, int $variant): string
    {
        $colorConstant = mb_strtoupper($color . '_' . $variant, 'UTF-8');

        if (!defined(Color::class . "::$colorConstant")) {
            throw new ColorNotFound($colorConstant);
        }

        return constant(Color::class . "::$colorConstant");
    }
}
