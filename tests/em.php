<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<em>text</em>');

    expect($html)->toBe("\e[3mtext\e[0m");
});

it('renders the element with <i> tag', function () {
    $html = parse('<i>text</i>');

    expect($html)->toBe("\e[3mtext\e[0m");
});
