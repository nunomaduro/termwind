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

        return $this->toElement($node, $children);
    }

    /**
     * Convert a given DOM node to it's termwind element equivalent.
     *
     * @param  array<int, Components\Element|string>  $children
     */
    private function toElement(DOMNode $node, array $children): Components\Element|string
    {
        if ($node instanceof DOMText) {
            $trimmedText = ltrim($node->textContent);
            $text = preg_replace('/\s+/', ' ', $trimmedText);

            return is_string($text) ? $text : $trimmedText;
        }

        /** @var \DOMElement $node */
        $styles = $node->getAttribute('class');

        return match ($node->nodeName) {
            'body' => $children[0], // Pick only the first element from the body node
            'div' => Termwind::div($children, $styles),
            'ul' => Termwind::ul($children, $styles),
            'ol' => Termwind::ol($children, $styles),
            'li' => Termwind::li($children, $styles),
            'dl' => Termwind::dl($children, $styles),
            'dt' => Termwind::dt($children, $styles),
            'dd' =>  Termwind::dd($children, $styles),
            'span' => Termwind::span($children, $styles),
            'br' => Termwind::breakLine(),
            'strong' => Termwind::div($children, $styles)->fontBold(),
            'em' => Termwind::div($children, $styles)->italic(),
            'a' => Termwind::anchor($children, $styles)->href($node->getAttribute('href')),
            'hr' => Termwind::hr($styles),
            default => Termwind::div($children),
        };
    }
}
