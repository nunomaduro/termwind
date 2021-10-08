<?php

use Termwind\Enums\Color;
use Termwind\Exceptions\ColorNotFound;
use function Termwind\{span};

it('adds font bold', function () {
    $span = span('string');

    $span = $span->fontBold();

    expect($span->toString())->toBe('<bg=default;options=bold>string</>');
});

it('adds underline', function () {
    $span = span('string');

    $span = $span->underline();

    expect($span->toString())->toBe('<bg=default;options=underscore>string</>');
});

it('adds padding left', function () {
    $span = span('string');

    $span = $span->pl(2);

    expect($span->toString())->toBe('<bg=default;options=>  string</>');
});

it('adds padding right', function () {
    $span = span('string');

    $span = $span->pr(2);

    expect($span->toString())->toBe('<bg=default;options=>string  </>');
});

it('adds horizontal padding', function () {
    $span = span('string');

    $span = $span->px(2);

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

    $span = $span->ml(2);
    $spanWithBackground = $spanWithBackground->ml(2);

    expect($span->toString())->toBe('  <bg=default;options=>string</>');
    expect($spanWithBackground->toString())->toBe('  <bg=white;options=>string</>');
});

it('adds margin right', function () {
    $span = span('string');
    $spanWithBackground = span('string')->bg('white');

    $span = $span->mr(2);
    $spanWithBackground = $spanWithBackground->mr(2);

    expect($span->toString())->toBe('<bg=default;options=>string</>  ');
    expect($spanWithBackground->toString())->toBe('<bg=white;options=>string</>  ');
});

it('adds horizontal margin', function () {
    $span = span('string');
    $spanWithBackground = span('string')->bg('white');

    $span = $span->mx(2);
    $spanWithBackground = $spanWithBackground->mx(2);

    expect($span->toString())->toBe('  <bg=default;options=>string</>  ');
    expect($spanWithBackground->toString())->toBe('  <bg=white;options=>string</>  ');
});

it('adds margin top', function () {
    $span = span('string');

    $span = $span->mt(2);

    expect($span->toString())->toBe("\n\n<bg=default;options=>string</>");
});

it('adds margin bottom', function () {
    $span = span('string');

    $span = $span->mb(2);

    expect($span->toString())->toBe("<bg=default;options=>string</>\n\n");
});

it('adds vertical margin', function () {
    $span = span('string');

    $span = $span->my(2);

    expect($span->toString())->toBe("\n\n<bg=default;options=>string</>\n\n");
});

it('adds margin', function () {
    $span = span('string');

    $span = $span->m(2);

    expect($span->toString())->toBe("\n\n  <bg=default;options=>string</>  \n\n");
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

it('sets the text with line-through', function () {
    $span = span('string');

    $span = $span->lineThrough();

    expect($span->toString())->toBe("<bg=default;options=>\e[9mstring\e[0m</>");
});

it('can receive bg-color class names as string', function () {
    $span = span('with color', 'bg-green-300');

    expect($span->toString())->toBe('<bg=#86efac;options=>with color</>');
});

it('can receive text-color class names as string', function () {
    $span = span('with color', 'text-color-green-300');

    expect($span->toString())->toBe('<bg=default;fg=#86efac;options=>with color</>');
});

it('throws if bg-color class names as string received is not found', function () {
    expect(
        fn () => span('with color', 'bg-invalidColor-300')
    )->toThrow(ColorNotFound::class);
});

it('throws if text-color class names as string received is not found', function () {
    expect(
        fn () => span('with color', 'text-color-invalidColor-300')
    )->toThrow(ColorNotFound::class);
});
