<?php

use NunoMaduro\TailCli\TailCli;
use Symfony\Component\Console\Output\BufferedOutput;

afterEach(fn () => TailCli::outputUsing(null));

it('renders', function () {
    $output = new BufferedOutput();

    TailCli::outputUsing($output);

    TailCli::render([
        TailCli::line(),
        TailCli::line('string')->pr1(),
    ]);

    expect($output->fetch())->toBe("\nstring \n");
});
