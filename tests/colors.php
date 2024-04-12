<?php

use Termwind\Exceptions\InvalidColor;

use function Termwind\parse;
use function Termwind\style;

it('allows the creation of colors', function () {
    style('black')->color('#101010');

    $html = parse('<span class="bg-black text-black">text</span>');

    expect($html)->toBe('<bg=#101010;fg=#101010>text</>');
});

it('can be used in a style', function () {
    style('blue-100')->color('#101010');
    style('btn')->apply('text-blue-100');

    $html = parse('<span class="btn">text</span>');

    expect($html)->toBe('<fg=#101010>text</>');
});

it('fails to create a color if is invalid', function () {
    expect(fn () => style('black')->color('#invalidcolor'))
        ->toThrow(InvalidColor::class);
});
