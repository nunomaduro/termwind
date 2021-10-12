<?php

use function Termwind\div;
use Termwind\Exceptions\InvalidChild;
use function Termwind\li;
use function Termwind\ol;

it('accepts multiple elements', function () {
    $ol = ol([
        li('list item 1', 'text-color-white'),
        li('list item 2', 'text-color-gray'),
    ]);

    expect($ol->toString())->toBe("<bg=default;options=><bg=default;fg=white;options=>1. list item 1</>\n<bg=default;fg=gray;options=>2. list item 2</></>");
});

it('only accepts li as children', function () {
    expect(fn () => ol([
        li('list item', 'text-color-white'),
        div('not list item', 'text-color-white'),
    ], 'bg-green'))->toThrow(InvalidChild::class);
});
