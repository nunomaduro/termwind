<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\div;
use function Termwind\render;
use function Termwind\renderUsing;
use function Termwind\span;

afterEach(fn () => renderUsing(null));

it('renders', function () {
    $output = new BufferedOutput();

    renderUsing($output);

    render([
        span(),
        span('string')->pr(1),
        div([
            span('a')->pr(1),
            span('b'),
        ]),
    ]);

    expect($output->fetch())->toBe("\nstring \na b\n");
});
