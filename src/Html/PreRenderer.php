<?php

declare(strict_types=1);

namespace Termwind\Html;

use Termwind\Components\Element;
use Termwind\Termwind;
use Termwind\ValueObjects\Node;
use function Termwind\terminal;

class PreRenderer
{
    /**
     * Highlights HTML content from a given node and converts to the content element.
     */
    public function toElement(Node $node): Element
    {
        $lines = explode("\n", $node->getHtml());

        $maxStrLen = array_reduce(
            $lines,
            static fn(int $max, string $line) => ($max < strlen($line)) ? strlen($line) : $max,
            0
        ) + 3;

        $styles = $node->getClassAttribute();
        $html = array_map(
            static fn(string $line) => (string) Termwind::div(str_pad($line, $maxStrLen), $styles),
            explode("\n", $node->getHtml())
        );

        return Termwind::raw(
            implode('', $html)
        );
    }
}
