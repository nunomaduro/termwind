<?php

use NunoMaduro\TailCli\TailCli;

test('font bold', function () {
    $line = TailCli::line('string');

    $line = $line->fontBold();

    expect($line->toString())->toBe('<bg=default;options=bold>string</>');
});

test('padding left', function () {
    $line = TailCli::line('string');

    $line = $line->pl2();

    expect($line->toString())->toBe('<bg=default;options=>  string</>');
});

test('padding right', function () {
    $line = TailCli::line('string');

    $line = $line->pr2();

    expect($line->toString())->toBe('<bg=default;options=>string  </>');
});

test('background color', function () {
    $line = TailCli::line('string');

    $line = $line->bg('red');

    expect($line->toString())->toBe('<bg=red;options=>string</>');
});

test('text color', function () {
    $line = TailCli::line('string');

    $line = $line->textColor('red');

    expect($line->toString())->toBe('<bg=default;fg=red;options=>string</>');
});

test('truncate', function () {
    $truncated = TailCli::line('string string');
    $normal = TailCli::line('string string');

    $truncated = $truncated->truncate(5);
    $line = $normal->truncate(5);

    expect($truncated->toString())->toBe('<bg=default;options=>st...</>');
    expect($line->toString())->toBe('<bg=default;options=>st...</>');
});

test('width', function () {
    $truncated = TailCli::line('string string');
    $normal = TailCli::line('string');

    $truncated = $truncated->width(10);
    $line = $normal->width(10);

    expect($truncated->toString())->toBe('<bg=default;options=>string str</>');
    expect($line->toString())->toBe('<bg=default;options=>string    </>');
});

test('margin left', function () {
    $line = TailCli::line('string');
    $lineWithBackground = TailCli::line('string')->bg('white');

    $line = $line->ml2();
    $lineWithBackground = $lineWithBackground->ml2();

    expect($line->toString())->toBe('  <bg=default;options=>string</>');
    expect($lineWithBackground->toString())->toBe('  <bg=white;options=>string</>');
});

test('margin right', function () {
    $line = TailCli::line('string');
    $lineWithBackground = TailCli::line('string')->bg('white');

    $line = $line->mr2();
    $lineWithBackground = $lineWithBackground->mr2();

    expect($line->toString())->toBe('<bg=default;options=>string</>  ');
    expect($lineWithBackground->toString())->toBe('<bg=white;options=>string</>  ');
});
