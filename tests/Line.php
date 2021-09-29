<?php

use function NunoMaduro\TailCli\{line};

it('adds font bold', function () {
    $line = line('string');

    $line = $line->fontBold();

    expect($line->toString())->toBe('<bg=default;options=bold>string</>');
});

it('adds padding left', function () {
    $line = line('string');

    $line = $line->pl2();

    expect($line->toString())->toBe('<bg=default;options=>  string</>');
});

it('adds padding right', function () {
    $line = line('string');

    $line = $line->pr2();

    expect($line->toString())->toBe('<bg=default;options=>string  </>');
});

it('adds background color', function () {
    $line = line('string');

    $line = $line->bg('red');

    expect($line->toString())->toBe('<bg=red;options=>string</>');
});

it('adds text color', function () {
    $line = line('string');

    $line = $line->textColor('red');

    expect($line->toString())->toBe('<bg=default;fg=red;options=>string</>');
});

it('truncates', function () {
    $truncated = line('string string');
    $normal = line('string string');

    $truncated = $truncated->truncate(5);
    $line = $normal->truncate(5);

    expect($truncated->toString())->toBe('<bg=default;options=>st...</>');
    expect($line->toString())->toBe('<bg=default;options=>st...</>');
});

it('adds width', function () {
    $truncated = line('string string');
    $normal = line('string');

    $truncated = $truncated->width(10);
    $line = $normal->width(10);

    expect($truncated->toString())->toBe('<bg=default;options=>string str</>');
    expect($line->toString())->toBe('<bg=default;options=>string    </>');
});

it('adds margin left', function () {
    $line = line('string');
    $lineWithBackground = line('string')->bg('white');

    $line = $line->ml2();
    $lineWithBackground = $lineWithBackground->ml2();

    expect($line->toString())->toBe('  <bg=default;options=>string</>');
    expect($lineWithBackground->toString())->toBe('  <bg=white;options=>string</>');
});

it('adds margin right', function () {
    $line = line('string');
    $lineWithBackground = line('string')->bg('white');

    $line = $line->mr2();
    $lineWithBackground = $lineWithBackground->mr2();

    expect($line->toString())->toBe('<bg=default;options=>string</>  ');
    expect($lineWithBackground->toString())->toBe('<bg=white;options=>string</>  ');
});
