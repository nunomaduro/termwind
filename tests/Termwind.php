<?php

use Symfony\Component\Console\Output\BufferedOutput;
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
    ]);

    expect($output->fetch())->toBe("\nstring \n");
});
