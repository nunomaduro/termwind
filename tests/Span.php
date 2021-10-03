<?php

use Termwind\Enums\Color;
use function Termwind\{span};

it('adds font bold', function () {
    $span = span('string');

    $span = $span->fontBold();

    expect($span->toString())->toBe('<bg=default;options=bold>string</>');
});

it('adds underspan', function () {
    $span = span('string');

    $span = $span->underline();

    expect($span->toString())->toBe('<bg=default;options=underscore>string</>');
});

it('adds padding left', function () {
    $span = span('string');

    $span = $span->pl2();

    expect($span->toString())->toBe('<bg=default;options=>  string</>');
});

it('adds padding right', function () {
    $span = span('string');

    $span = $span->pr2();

    expect($span->toString())->toBe('<bg=default;options=>string  </>');
});

it('adds horizontal padding', function () {
    $span = span('string');

    $span = $span->px2();

    expect($span->toString())->toBe('<bg=default;options=>  string  </>');
});

it('adds background color', function () {
    $span = span('string');

    $span = $span->bg('red');

    expect($span->toString())->toBe('<bg=red;options=>string</>');
});

it('adds background color using color enum', function () {
    $span = span('string');

    $span = $span->bg(Color::RED_400);

    expect($span->toString())->toBe('<bg=#f87171;options=>string</>');
});

it('adds text color', function () {
    $span = span('string');

    $span = $span->textColor('red');

    expect($span->toString())->toBe('<bg=default;fg=red;options=>string</>');
});

it('adds text color using color enum', function () {
    $span = span('string');

    $span = $span->textColor(Color::RED_400);

    expect($span->toString())->toBe('<bg=default;fg=#f87171;options=>string</>');
});

it('truncates', function () {
    $truncated = span('string string');
    $normal = span('string string');

    $truncated = $truncated->truncate(5);
    $span = $normal->truncate(5);

    expect($truncated->toString())->toBe('<bg=default;options=>st...</>');
    expect($span->toString())->toBe('<bg=default;options=>st...</>');
});

it('adds width', function () {
    $truncated = span('string string');
    $normal = span('string');

    $truncated = $truncated->width(10);
    $span = $normal->width(10);

    expect($truncated->toString())->toBe('<bg=default;options=>string str</>');
    expect($span->toString())->toBe('<bg=default;options=>string    </>');
});

it('adds margin left', function () {
    $span = span('string');
    $spanWithBackground = span('string')->bg('white');

    $span = $span->ml2();
    $spanWithBackground = $spanWithBackground->ml2();

    expect($span->toString())->toBe('  <bg=default;options=>string</>');
    expect($spanWithBackground->toString())->toBe('  <bg=white;options=>string</>');
});

it('adds margin right', function () {
    $span = span('string');
    $spanWithBackground = span('string')->bg('white');

    $span = $span->mr2();
    $spanWithBackground = $spanWithBackground->mr2();

    expect($span->toString())->toBe('<bg=default;options=>string</>  ');
    expect($spanWithBackground->toString())->toBe('<bg=white;options=>string</>  ');
});

it('adds horizontal margin', function () {
    $span = span('string');
    $spanWithBackground = span('string')->bg('white');

    $span = $span->mx2();
    $spanWithBackground = $spanWithBackground->mx2();

    expect($span->toString())->toBe('  <bg=default;options=>string</>  ');
    expect($spanWithBackground->toString())->toBe('  <bg=white;options=>string</>  ');
});

it('sets the text uppercase', function () {
    $span = span('string');

    $span = $span->uppercase();

    expect($span->toString())->toBe('<bg=default;options=>STRING</>');
});

it('sets the text lowercase', function () {
    $span = span('STRing');

    $span = $span->lowercase();

    expect($span->toString())->toBe('<bg=default;options=>string</>');
});

it('sets the text capitalize', function () {
    $span = span('STRING capitalized');

    $span = $span->capitalize();

    expect($span->toString())->toBe('<bg=default;options=>String Capitalized</>');
});

it('sets the text in snakecase', function () {
    $span = span('SnakeCase snakeCase snakeCASE SNAKECase');

    $span = $span->snakecase();

    expect($span->toString())->toBe('<bg=default;options=>snake_case snake_case snake_case snake_case</>');
});
