<?php

use Termwind\Exceptions\StyleNotFound;
use function Termwind\style;

it('allows the creation of styles', function () {
    style('btn')->apply('p-4 bg-blue text-color-white');

    $html = parse('<a class="btn">link text</a>');

    expect($html)->toBe('<href=link text;bg=blue;fg=white;options=>    link text    </>');
});

it('disalows the usage of non-defined styles', function () {
    expect(fn () => parse('<a class="btn">link text</a>'))
        ->toThrow(StyleNotFound::class);
});
