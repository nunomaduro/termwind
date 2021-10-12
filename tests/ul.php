<?php

use function Termwind\div;
use Termwind\Exceptions\InvalidChild;
use function Termwind\li;
use function Termwind\ul;

it('accepts multiple elements', function () {
    $ul = ul([
        li('list item 1', 'text-color-white'),
        li('list item 2', 'text-color-gray'),
    ]);

    expect($ul->toString())->toBe("<bg=default;options=><bg=default;fg=white;options=>• list item 1</>\n<bg=default;fg=gray;options=>• list item 2</></>");
});

it('only accepts li as children', function () {
    expect(fn () => ul([
        li('list item', 'text-color-white'),
        div('not list item', 'text-color-white'),
    ], 'bg-green'))->toThrow(InvalidChild::class);
});
