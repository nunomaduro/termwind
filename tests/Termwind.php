<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\line;
use function Termwind\render;
use function Termwind\renderUsing;

afterEach(fn () => renderUsing(null));

it('renders', function () {
    $output = new BufferedOutput();

    renderUsing($output);

    render([
        line(),
        line('string')->pr1(),
    ]);

    expect($output->fetch())->toBe("\nstring \n");
});
