<?php

declare(strict_types = 1);

namespace Termwind\Components;

use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Actions\StyleToMethod;
use Termwind\ValueObjects\StylesFormatter;

/**
 * @internal
 * @mixin StylesFormatter
 */
abstract class Element
{
    /**
     * Creates an element instance.
     */
    final public function __construct(
        protected OutputInterface $output,
        protected string $content,
        protected ?StylesFormatter $formatter = null
    ) {
        if ($formatter === null) {
            $this->formatter = new StylesFormatter();
        }
    }

    /**
     * Creates an element instance with the given styles.
     */
    final public static function fromStyles(OutputInterface $output, string $content, string $styles): static
    {
        $styles = StyleToMethod::multiple(new StylesFormatter(), $styles);

        return new static($output, $content, $styles);
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
        return $this->formatter->format($this->content);
    }

    /**
     * Get the string representation of the element.
     */
    final public function __toString(): string
    {
        return $this->toString();
    }

    public function __call(string $name, array $arguments): self
    {
        if (method_exists($this->formatter, $name)) {
            $this->formatter->{$name}(...$arguments);
            return $this;
        }

        throw new \BadMethodCallException("Method {$name} is not found.");

    }
}
