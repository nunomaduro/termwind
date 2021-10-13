<?php

use function Termwind\div;
use Termwind\Exceptions\InvalidChild;

it('renders the element', function () {
    $html = parse('<ul><li>list text 1</li></ul>');

    expect($html)->toBe('<bg=default;options=><bg=default;options=>• list text 1</></>');
});

it('renders only "li" as children', function () {
    expect(fn () => parse('<ul><div>list text 1</div></ul>'))
        ->toThrow(InvalidChild::class);
});

