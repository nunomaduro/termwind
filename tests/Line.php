<?php

use NunoMaduro\TailCli\TailCli;

test('padding left', function () {
    $line = TailCli::line('string');

    $line = $line->pl2();

    expect($line->toString())->toBe('  string');
});

test('padding right', function () {
    $line = TailCli::line('string');

    $line = $line->pr2();

    expect($line->toString())->toBe('  string');
});

test('background color', function () {
    $line = TailCli::line('string');

    $line = $line->bg('red');

    expect($line->toString())->toBe('<bg=red>string</>');
});

test('text color', function () {
    $line = TailCli::line('string');

    $line = $line->textColor('red');

    expect($line->toString())->toBe('<fg=red>string</>');
});

test('truncate', function () {
    $truncated = TailCli::line('string string');
    $normal = TailCli::line('string string');

    $truncated = $truncated->truncate(5);
    $line = $normal->truncate(5);

    expect($truncated->toString())->toBe('st...');
    expect($line->toString())->toBe('st...');
});

