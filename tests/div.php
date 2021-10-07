<?php

use function Termwind\a;
use function Termwind\div;
use Termwind\Enums\Color;

it('accepts multiple elements', function () {
    $div = div([
        a('foo', 'ml-2'),
        div([a('foo', 'ml-2')]),
        'string',
    ], 'ml-2 bg-white');

    expect($div->toString())->toBe('<bg=default;options=>  <href=foo;bg=default;options=>foo</><bg=default;options=>  <href=foo;bg=default;options=>foo</></>string</>');
});

it('adds font bold', function () {
    $div = div('string');

    $div = $div->fontBold();

    expect($div->toString())->toBe('<bg=default;options=bold>string</>');
});

it('adds underline', function () {
    $div = div('string');

    $div = $div->underline();

    expect($div->toString())->toBe('<bg=default;options=underscore>string</>');
});

it('adds padding left', function () {
    $div = div('string');

    $div = $div->pl(2);

    expect($div->toString())->toBe('<bg=default;options=>  string</>');
});

it('adds padding right', function () {
    $div = div('string');

    $div = $div->pr(2);

    expect($div->toString())->toBe('<bg=default;options=>string  </>');
});

it('adds horizontal padding', function () {
    $div = div('string');

    $div = $div->px(2);

    expect($div->toString())->toBe('<bg=default;options=>  string  </>');
});

it('adds background color', function () {
    $div = div('string');

    $div = $div->bg('red');

    expect($div->toString())->toBe('<bg=red;options=>string</>');
});

it('adds background color using color enum', function () {
    $div = div('string');

    $div = $div->bg(Color::RED_400);

    expect($div->toString())->toBe('<bg=#f87171;options=>string</>');
});

it('adds text color', function () {
    $div = div('string');

    $div = $div->textColor('red');

    expect($div->toString())->toBe('<bg=default;fg=red;options=>string</>');
});

it('adds text color using color enum', function () {
    $div = div('string');

    $div = $div->textColor(Color::RED_400);

    expect($div->toString())->toBe('<bg=default;fg=#f87171;options=>string</>');
});

it('truncates', function () {
    $truncated = div('string string');
    $normal = div('string string');

    $truncated = $truncated->truncate(5);
    $div = $normal->truncate(5);

    expect($truncated->toString())->toBe('<bg=default;options=>st...</>');
    expect($div->toString())->toBe('<bg=default;options=>st...</>');
});

it('adds width', function () {
    $truncated = div('string string');
    $normal = div('string');

    $truncated = $truncated->width(10);
    $div = $normal->width(10);

    expect($truncated->toString())->toBe('<bg=default;options=>string str</>');
    expect($div->toString())->toBe('<bg=default;options=>string    </>');
});

it('adds margin left', function () {
    $div = div('string');
    $divWithBackground = div('string')->bg('white');

    $div = $div->ml(2);
    $divWithBackground = $divWithBackground->ml(2);

    expect($div->toString())->toBe('  <bg=default;options=>string</>');
    expect($divWithBackground->toString())->toBe('  <bg=white;options=>string</>');
});

it('adds margin right', function () {
    $div = div('string');
    $divWithBackground = div('string')->bg('white');

    $div = $div->mr(2);
    $divWithBackground = $divWithBackground->mr(2);

    expect($div->toString())->toBe('<bg=default;options=>string</>  ');
    expect($divWithBackground->toString())->toBe('<bg=white;options=>string</>  ');
});

it('adds horizontal margin', function () {
    $div = div('string');
    $divWithBackground = div('string')->bg('white');

    $div = $div->mx(2);
    $divWithBackground = $divWithBackground->mx(2);

    expect($div->toString())->toBe('  <bg=default;options=>string</>  ');
    expect($divWithBackground->toString())->toBe('  <bg=white;options=>string</>  ');
});

it('adds margin top', function () {
    $div = div('string');

    $div = $div->mt(2);

    expect($div->toString())->toBe("\n\n<bg=default;options=>string</>");
});

it('adds margin bottom', function () {
    $div = div('string');

    $div = $div->mb(2);

    expect($div->toString())->toBe("<bg=default;options=>string</>\n\n");
});

it('adds vertical margin', function () {
    $div = div('string');

    $div = $div->my(2);

    expect($div->toString())->toBe("\n\n<bg=default;options=>string</>\n\n");
});

it('adds margin', function () {
    $div = div('string');

    $div = $div->m(2);

    expect($div->toString())->toBe("\n\n  <bg=default;options=>string</>  \n\n");
});

it('sets the text uppercase', function () {
    $div = div('string');

    $div = $div->uppercase();

    expect($div->toString())->toBe('<bg=default;options=>STRING</>');
});

it('sets the text lowercase', function () {
    $div = div('STRing');

    $div = $div->lowercase();

    expect($div->toString())->toBe('<bg=default;options=>string</>');
});

it('sets the text capitalize', function () {
    $div = div('STRING capitalized');

    $div = $div->capitalize();

    expect($div->toString())->toBe('<bg=default;options=>String Capitalized</>');
});

it('sets the text in snakecase', function () {
    $div = div('SnakeCase snakeCase snakeCASE SNAKECase');

    $div = $div->snakecase();

    expect($div->toString())->toBe('<bg=default;options=>snake_case snake_case snake_case snake_case</>');
});

it('sets the text with line-through', function () {
    $div = div('string');

    $div = $div->lineThrough();

    expect($div->toString())->toBe("<bg=default;options=>\e[9mstring\e[0m</>");
});
