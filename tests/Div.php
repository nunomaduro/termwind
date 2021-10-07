<?php

use function Termwind\a;
use function Termwind\div;

it('accepts multiple elements', function () {
    $div = div([
        a('foo', 'ml-2'),
        div([a('foo', 'ml-2')]),
        'string',
    ]);

    expect($div->toString())->toBe('<bg=default;options=>  <href=foo;bg=default;options=>foo</><bg=default;options=>  <href=foo;bg=default;options=>foo</></>string</>');
});
