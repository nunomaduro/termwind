<?php

declare(strict_types=1);

namespace Termwind;

use DOMDocument;
use DOMNode;
use DOMText;

/**
 * @internal
 */
final class HtmlRenderer
{
    /**
     * Renders the given hmtl.
     */
    public function render(string $html): void
    {
        $this->parse($html)->render();
    }

    /**
     * Parses the given html.
     */
    public function parse(string $html): Components\Element
    {
        $dom = new DOMDocument();

        $html = '<?xml encoding="UTF-8">'.trim($html);
        $dom->loadHTML($html, LIBXML_COMPACT | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOXMLDECL);

        /** @var DOMNode $body */
        $body = $dom->getElementsByTagName('body')->item(0);
        $el = $this->convert($body);

        // @codeCoverageIgnoreStart
        return is_string($el)
            ? Termwind::span($el)
            : $el;
        // @codeCoverageIgnoreEnd
    }

    /**
     * Convert a tree of DOM nodes to a tree of termwind elements.
     */
    private function convert(DOMNode $node): Components\Element|string
    {
        $children = [];

        foreach ($node->childNodes as $child) {
            $children[] = $this->convert($child);
        }

        $children = array_filter($children, fn ($child) => $child !== '');

        $isFirstChild = is_null($node->previousSibling);

        $previous = $node->previousSibling;
        while ($previous) {
            if (preg_replace('/\s+/', '', $previous->nodeValue) !== '') {
                break;
            }

            $previous = $previous->previousSibling;
        }

        return $this->toElement($node, $children, is_null($previous));
    }

    /**
     * Convert a given DOM node to it's termwind element equivalent.
     *
     * @param  array<int, Components\Element|string>  $children
     */
    private function toElement(DOMNode $node, array $children, bool $isFirstChild = false): Components\Element|string
    {
        if ($node instanceof DOMText) {
            $trimedText = ltrim($node->textContent);
            $text = preg_replace('/\s+/', ' ', $trimedText);

            return is_string($text) ? $text : $trimedText;
        }

        /** @var \DOMElement $node */
        $styles = $node->getAttribute('class');

        return match ($node->nodeName) {
            'body' => $children[0], // Pick only the first element from the body node
            'div' => Termwind::div($children, $styles, $isFirstChild),
            'ul' => Termwind::ul($children, $styles, $isFirstChild),
            'ol' => Termwind::ol($children, $styles, $isFirstChild),
            'li' => Termwind::li($children, $styles, $isFirstChild),
            'dl' => Termwind::dl($children, $styles, $isFirstChild),
            'dt' => Termwind::dt($children, $styles, $isFirstChild),
            'dd' =>  Termwind::dd($children, $styles, $isFirstChild),
            'span' => Termwind::span($children, $styles, $isFirstChild),
            'br' => Termwind::breakLine(),
            'strong' => Termwind::span($children, $styles, $isFirstChild)->fontBold(),
            'em' => Termwind::span($children, $styles, $isFirstChild)->italic(),
            'a' => Termwind::anchor($children, $styles, $isFirstChild)->href($node->getAttribute('href')),
            'hr' => Termwind::hr($styles, $isFirstChild),
            default => Termwind::div($children, $styles, $isFirstChild),
        };
    }
}
