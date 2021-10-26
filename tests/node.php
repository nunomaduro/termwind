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
    $doc = new \DOMDocument("1.0");
    $node = $doc->createElement("div");
    $el = $doc->appendChild($node);
    $el->setAttribute('foo', 'bar');
    $node = new Node($el);

    expect($node->getAttribute('foo'))->toBe('bar');
});
