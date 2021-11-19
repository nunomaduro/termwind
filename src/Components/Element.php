<?php

declare(strict_types=1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\StyleToMethod;
use Termwind\ValueObjects\Styles;

/**
 * @internal
 * @method Element inheritFromStyles(Styles $styles)
 * @method Element fontBold()
 * @method Element italic()
 * @method Element underline()
 * @method Element lineThrough()
 * @method Element href(string $href)
 * @method Element addStyle(string $style)
 */
abstract class Element
{
    /** @var string[] */
    protected static array $defaultStyles = [];
    protected Styles $styles;

    /**
     * Creates an element instance.
     */
    final public function __construct(
        protected OutputInterface $output,
        protected string $content,
        Styles|null $styles = null
    ) {
        $this->styles = $styles ?? new Styles(defaultStyles: static::$defaultStyles);
        $this->styles->setElement($this);
    }

    /**
     * Creates an element instance with the given styles.
     *
     * @param  array<string, mixed>  $properties
     */
    final public static function fromStyles(OutputInterface $output, string $content, string $styles = '', array $properties = []): static
    {
        $element = new static($output, $content);
        if ($properties !== []) {
            $element->styles->setProperties($properties);
        }

        $elementStyles = StyleToMethod::multiple($element->styles, $styles);

        return new static($output, $content, $elementStyles);
    }

    /**
     * Get the string representation of the element.
     */
    public function toString(): string
    {
        return $this->styles->format($this->content);
    }

    /**
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this->styles, $name)) {
            $result = $this->styles->{$name}(...$arguments);

            if (str_starts_with($name, 'get') || str_starts_with($name, 'has')) {
                return $result;
            }

            return $this;
        }

        throw new \BadMethodCallException("Method {$name} is not found.");
    }

    /**
     * Sets the content of the element.
     */
    final public function setContent(string $content): static
    {
        return new static($this->output, $content, $this->styles);
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
    final public function __toString(): string
    {
        return $this->toString();
    }
}
