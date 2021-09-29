<?php

use NunoMaduro\TailCli\TailCli;
use Symfony\Component\Console\Output\BufferedOutput;

afterEach(fn () => TailCli::outputUsing(null));

test('writes the element to the output', function () {
    $output = new BufferedOutput();

    TailCli::outputUsing($output);

    TailCli::line('string')->textColor('red')->write();

    expect($output->fetch())->toBe('string');
});

test('writes the element to the output and prints a new line', function () {
    $output = new BufferedOutput();

    TailCli::outputUsing($output);

    TailCli::line('string')->textColor('red')->writeln();

    expect($output->fetch())->toBe("string\n");
});
