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

        return is_string($el)
            ? Termwind::span($el)
            : $el;
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
            return trim($node->textContent);
        }

        /** @var \DOMElement $node */
        $styles = $node->getAttribute('class');

        if ($node->nodeName === 'body') {
            // Pick only the first element from the body node
            return $children[0];
        }

        if ($node->nodeName === 'div') {
            return Termwind::div($children, $styles);
        }

        if ($node->nodeName === 'ul') {
            return Termwind::ul($children, $styles);
        }

        if ($node->nodeName === 'ol') {
            return Termwind::ol($children, $styles);
        }

        if ($node->nodeName === 'li') {
            return Termwind::li($children, $styles);
        }

        if ($node->nodeName === 'span') {
            return Termwind::span($children, $styles);
        }

        if ($node->nodeName === 'br') {
            return Termwind::breakLine();
        }

        if ($node->nodeName === 'strong') {
            return Termwind::div($children, $styles)->fontBold();
        }

        if ($node->nodeName === 'em') {
            return Termwind::div($children, $styles)->italic();
        }

        if ($node->nodeName === 'a') {
            $a = Termwind::anchor($node->textContent, $styles);

            if (strlen($href = $node->getAttribute('href')) > 0) {
                $a = $a->href($href);
            }

            return $a;
        }

        return Termwind::div($children);
    }
}
