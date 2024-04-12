<?php

use Termwind\Exceptions\StyleNotFound;

use function Termwind\parse;
use function Termwind\style;

it('allows the creation of styles', function () {
    style('btn')->apply('px-4 bg-blue text-white');

    $html = parse('<a class="btn">link text</a>');

    expect($html)->toBe('<bg=blue;fg=white>    link text    </>');
});

it('disalows the usage of non-defined styles', function () {
    expect(fn () => parse('<a class="btn">link text</a>'))
        ->toThrow(StyleNotFound::class);
});
