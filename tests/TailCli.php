<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function TailCli\{
    line, render, renderUsing
};

afterEach(fn() => renderUsing(null));

it('renders', function () {
    $output = new BufferedOutput();

    renderUsing($output);

    render([
        line(),
        line('string')->pr1(),
    ]);

    expect($output->fetch())->toBe("\nstring \n");
});
