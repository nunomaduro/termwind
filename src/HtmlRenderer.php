<?php

declare(strict_types=1);

namespace Termwind;

use DOMDocument;
use DOMNode;
use DOMText;

final class HtmlRenderer
{
    public static function create(): HtmlRenderer
    {
        return new static;
    }

    public function render(string $html): Components\Element
    {
        $dom = new DOMDocument();

        // The XML declaration here is required to load UTF-8 HTML
        $html = "<?xml encoding=\"UTF-8\">{$html}";
        $dom->loadHTML($html, LIBXML_COMPACT | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOXMLDECL);

        /** @var DOMNode $body */
        $body = $dom->getElementsByTagName("body")->item(0);

        $el = $this->convert($body);

        if (is_string($el)) {
            return Termwind::span($el);
        }

        return $el;
    }

    /**
     * Convert a tree of DOM nodes to a tree of termwind elements
     *
     * @param DOMNode $node
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
     * Convert a given DOM node to it's termwind element equivalent
     *
     * @param DOMNode $node
     * @param (Components\Element|string)[] $children
     */
    private function toElement(DOMNode $node, array $children): Components\Element|string
    {
        if ($node instanceof DOMText) {
            return $node->textContent;
        }

        /** @var \DOMElement $node */
        $styles = $node->getAttribute("class");

        if ($node->nodeName === "body") {
            // Pick only the first element from the body node
            return $children[0];
        }

        if ($node->nodeName === "div") {
            return Termwind::div($children, $styles);
        }

        if ($node->nodeName === "span") {
            return Termwind::div($children, $styles);
        }

        if ($node->nodeName === "br") {
            return Termwind::breakLine();
        }

        if ($node->nodeName === "a") {
            $href = $node->getAttribute("href");

            if ($href === "") {
                $href = $node->textContent;
            }

            return Termwind::anchor($href, $styles);
        }

        return Termwind::div($children);
    }
}
