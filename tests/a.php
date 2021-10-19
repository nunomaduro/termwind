<?php

use function Termwind\{a};

it('renders the element', function () {
    $html = parse('<a>link text</a>');

    expect($html)->toBe('link text');
});

it('renders the href property', function () {
    $html = parse('<a href="url">link text</a>');

    expect($html)->toBe('<href=url>link text</>');
});
