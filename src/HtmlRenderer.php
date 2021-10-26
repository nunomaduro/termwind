<?php

declare(strict_types=1);

namespace Termwind;

use DOMComment;
use DOMDocument;
use DOMNode;
use DOMText;
use Termwind\Actions\CodeHighlighter;
use Termwind\Html\TableRenderer;

/**
 * @internal
 */
final class HtmlRenderer
{
    /**
     * Renders the given html.
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

        $html = '<?xml version="1.0" encoding="UTF-8">'.trim($html);
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
     * Checks if the node is empty.
     */
    private function isNodeEmpty(DOMNode $node): bool
    {
        return $node instanceof DOMText &&
            preg_replace('/\s+/', '', $node->nodeValue) === '';
    }

    /**
     * Gets the previous sibling from a node.
     */
    private function getNodePreviousSibling(DOMNode $node): DOMNode|null
    {
        while ($node = $node->previousSibling) {
            if ($this->isNodeEmpty($node)) {
                continue;
            }

            if (! $node instanceof DOMComment) {
                return $node;
            }
        }

        return $node;
    }

    /**
     * Gets the next sibling from a node.
     */
    private function getNodeNextSibling(DOMNode $node): DOMNode|null
    {
        while ($node = $node->nextSibling) {
            if ($this->isNodeEmpty($node)) {
                continue;
            }

            if (! $node instanceof DOMComment) {
                return $node;
            }
        }

        return $node;
    }

    /**
     * Checks if the node is the first child.
     */
    private function isNodeFirstChild(DOMNode $node): bool
    {
        return is_null($this->getNodePreviousSibling($node));
    }

    /**
     * Convert a tree of DOM nodes to a tree of termwind elements.
     */
    private function convert(DOMNode $node): Components\Element|string
    {
        $children = [];

        if ($node->nodeName === 'table') {
            return (new TableRenderer($node))->toElement();
        } elseif ($node->nodeName === 'code') {
            $html = '';
            foreach ($node->childNodes as $child) {
                if ($child->ownerDocument instanceof \DOMDocument) {
                    $html .= $child->ownerDocument->saveXML($child);
                }
            }

            $line = max((int) $node->getAttribute('line'), 1);
            $startLine = max((int) $node->getAttribute('start-line'), 1);

            $html = html_entity_decode($html);

            return Termwind::raw(
                (new CodeHighlighter())->highlight($html, $line, $startLine)
            );
        } elseif ($node->nodeName === 'pre') {
            $html = '';
            foreach ($node->childNodes as $child) {
                if ($child->ownerDocument instanceof \DOMDocument) {
                    $html .= $child->ownerDocument->saveXML($child);
                }
            }

            return Termwind::raw(html_entity_decode($html));
        }

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
        if ($node instanceof DOMComment) {
            return '';
        }

        if ($node instanceof DOMText) {
            $text = preg_replace('/\s+/', ' ', $node->textContent) ?? '';

            if (is_null($this->getNodePreviousSibling($node))) {
                $text = ltrim($text);
            }

            if (is_null($this->getNodeNextSibling($node))) {
                $text = rtrim($text);
            }

            return $text;
        }

        /** @var array<string, mixed> $properties */
        $properties = [
            'isFirstChild' => $this->isNodeFirstChild($node),
        ];

        /** @var \DOMElement $node */
        $styles = $node->getAttribute('class');

        return match ($node->nodeName) {
            'body' => $children[0], // Pick only the first element from the body node
            'div' => Termwind::div($children, $styles, $properties),
            'ul' => Termwind::ul($children, $styles, $properties),
            'ol' => Termwind::ol($children, $styles, $properties),
            'li' => Termwind::li($children, $styles, $properties),
            'dl' => Termwind::dl($children, $styles, $properties),
            'dt' => Termwind::dt($children, $styles, $properties),
            'dd' => Termwind::dd($children, $styles, $properties),
            'span' => Termwind::span($children, $styles, $properties),
            'br' => Termwind::breakLine(),
            'strong' => Termwind::span($children, $styles, $properties)->fontBold(),
            'em' => Termwind::span($children, $styles, $properties)->italic(),
            'a' => Termwind::anchor($children, $styles, $properties)->href($node->getAttribute('href')),
            'hr' => Termwind::hr($styles, $properties),
            default => Termwind::div($children, $styles, $properties),
        };
    }
}
