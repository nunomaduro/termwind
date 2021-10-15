<?php

use Termwind\Exceptions\InvalidChild;

it('renders the element', function () {
    $html = parse('<ol><li>list text 1</li></ol>');

    expect($html)->toBe('1. list text 1');
});

it('renders only "li" as children', function () {
    expect(fn () => parse('<ol><div>list text 1</div></ol>'))
        ->toThrow(InvalidChild::class);
});

it('renders "li" elements and ignore empty spaces', function () {
    $html = parse("<ol> <li>list text 1</li>\n\n\n</ol>");

    expect($html)->toBe('1. list text 1');
});
