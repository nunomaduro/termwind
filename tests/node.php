<?php

use Termwind\ValueObjects\Node;

it('it should return empty string for dom comment', function () {
    $node = new Node(new \DOMComment('You will not be able to see this text.'));

    expect($node->getAttribute('foo'))->toBe('');
});

it('it should return empty string for dom text', function () {
    $node = new Node(new \DOMText('bar'));

    expect($node->getAttribute('foo'))->toBe('');
});

it('it should return bar for dom element', function () {
    $doc = new \DOMDocument('1.0');
    $node = $doc->createElement('div');
    $el = $doc->appendChild($node);
    $el->setAttribute('foo', 'bar');
    $node = new Node($el);

    expect($node->getAttribute('foo'))->toBe('bar');
});

it('gets next sibling node with empty text', function () {
    $dom = new DOMDocument;

    $html = '<?xml encoding="UTF-8"><body><div></div>     <div></div></body>';
    $dom->loadHTML($html, LIBXML_COMPACT | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOXMLDECL);

    $body = $dom->getElementsByTagName('body')->item(0);
    $node = new Node($body->firstChild);

    expect($node->getNextSibling()->getNextSibling())->toBeNull();
});

it('gets next sibling node with empty line', function () {
    $dom = new DOMDocument;

    $html = "<?xml encoding=\"UTF-8\"><body><div></div>\n<div></div></body>";
    $dom->loadHTML($html, LIBXML_COMPACT | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOXMLDECL);

    $body = $dom->getElementsByTagName('body')->item(0);
    $node = new Node($body->firstChild);

    expect($node->getNextSibling()->getNextSibling())->toBeNull();
});

it('gets next sibling node with comment', function () {
    $dom = new DOMDocument;

    $html = '<?xml encoding="UTF-8"><body><div></div><!-- Hello world --><div></div></body>';
    $dom->loadHTML($html, LIBXML_COMPACT | LIBXML_HTML_NODEFDTD | LIBXML_NOBLANKS | LIBXML_NOXMLDECL);

    $body = $dom->getElementsByTagName('body')->item(0);
    $node = new Node($body->firstChild);

    expect($node->getNextSibling()->getNextSibling())->toBeNull();
});
