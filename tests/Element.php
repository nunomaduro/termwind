<?php

use NunoMaduro\TailCli\TailCli;
use Symfony\Component\Console\Output\BufferedOutput;

afterEach(fn () => TailCli::outputUsing(null));

it('renders', function () {
    $output = new BufferedOutput();

    TailCli::outputUsing($output);

    TailCli::line('string')->textColor('red')->render();

    expect($output->fetch())->toBe("string\n");
});
