<?php

use Termwind\Enums\Color;
use function Termwind\{a};

it('renders an anchor', function () {
    $anchor = a('https://github.com/nunomaduro/termwind');
    $anchorWithValue = a('Termwind', 'p-2');

    $anchorWithValue = $anchorWithValue->href('https://github.com/nunomaduro/termwind');

    expect($anchor->toString())->toBe('<href=https://github.com/nunomaduro/termwind;bg=default;options=>https://github.com/nunomaduro/termwind</>');
    expect($anchorWithValue->toString())->toBe('<href=https://github.com/nunomaduro/termwind;bg=default;options=>  Termwind  </>');
});

it('adds font bold', function () {
    $a = a('string');

    $a = $a->fontBold();

    expect($a->toString())->toBe('<href=string;bg=default;options=bold>string</>');
});

it('adds underline', function () {
    $a = a('string');

    $a = $a->underline();

    expect($a->toString())->toBe('<href=string;bg=default;options=underscore>string</>');
});

it('adds padding left', function () {
    $a = a('string');

    $a = $a->pl(2);

    expect($a->toString())->toBe('<href=string;bg=default;options=>  string</>');
});

it('adds padding right', function () {
    $a = a('string');

    $a = $a->pr(2);

    expect($a->toString())->toBe('<href=string;bg=default;options=>string  </>');
});

it('adds horizontal padding', function () {
    $a = a('string');

    $a = $a->px(2);

    expect($a->toString())->toBe('<href=string;bg=default;options=>  string  </>');
});

it('adds background color', function () {
    $a = a('string');

    $a = $a->bg('red');

    expect($a->toString())->toBe('<href=string;bg=red;options=>string</>');
});

it('adds background color using color enum', function () {
    $a = a('string');

    $a = $a->bg(Color::RED_400);

    expect($a->toString())->toBe('<href=string;bg=#f87171;options=>string</>');
});

it('adds text color', function () {
    $a = a('string');

    $a = $a->textColor('red');

    expect($a->toString())->toBe('<href=string;bg=default;fg=red;options=>string</>');
});

it('adds text color using color enum', function () {
    $a = a('string');

    $a = $a->textColor(Color::RED_400);

    expect($a->toString())->toBe('<href=string;bg=default;fg=#f87171;options=>string</>');
});

it('truncates', function () {
    $truncated = a('string');
    $normal = a('string');

    $truncated = $truncated->truncate(5);
    $a = $normal->truncate(5);

    expect($truncated->toString())->toBe('<href=string;bg=default;options=>st...</>');
    expect($a->toString())->toBe('<href=string;bg=default;options=>st...</>');
});

it('adds width', function () {
    $truncated = a('stringstring');
    $normal = a('string');

    $truncated = $truncated->width(10);
    $a = $normal->width(10);

    expect($truncated->toString())->toBe('<href=stringstring;bg=default;options=>stringstri</>');
    expect($a->toString())->toBe('<href=string;bg=default;options=>string    </>');
});

it('adds margin left', function () {
    $a = a('string');
    $aWithBackground = a('string')->bg('white');

    $a = $a->ml(2);
    $aWithBackground = $aWithBackground->ml(2);

    expect($a->toString())->toBe('  <href=string;bg=default;options=>string</>');
    expect($aWithBackground->toString())->toBe('  <href=string;bg=white;options=>string</>');
});

it('adds margin right', function () {
    $a = a('string');
    $aWithBackground = a('string')->bg('white');

    $a = $a->mr(2);
    $aWithBackground = $aWithBackground->mr(2);

    expect($a->toString())->toBe('<href=string;bg=default;options=>string</>  ');
    expect($aWithBackground->toString())->toBe('<href=string;bg=white;options=>string</>  ');
});

it('adds horizontal margin', function () {
    $a = a('string');
    $aWithBackground = a('string')->bg('white');

    $a = $a->mx(2);
    $aWithBackground = $aWithBackground->mx(2);

    expect($a->toString())->toBe('  <href=string;bg=default;options=>string</>  ');
    expect($aWithBackground->toString())->toBe('  <href=string;bg=white;options=>string</>  ');
});

it('adds margin top', function () {
    $a = a('string');

    $a = $a->mt(2);

    expect($a->toString())->toBe("\n\n<href=string;bg=default;options=>string</>");
});

it('adds margin bottom', function () {
    $a = a('string');

    $a = $a->mb(2);

    expect($a->toString())->toBe("<href=string;bg=default;options=>string</>\n\n");
});

it('adds vertical margin', function () {
    $a = a('string');

    $a = $a->my(2);

    expect($a->toString())->toBe("\n\n<href=string;bg=default;options=>string</>\n\n");
});

it('adds margin', function () {
    $a = a('string');

    $a = $a->m(2);

    expect($a->toString())->toBe("\n\n  <href=string;bg=default;options=>string</>  \n\n");
});

it('sets the text uppercase', function () {
    $a = a('string');

    $a = $a->uppercase();

    expect($a->toString())->toBe('<href=string;bg=default;options=>STRING</>');
});

it('sets the text lowercase', function () {
    $a = a('STRing');

    $a = $a->lowercase();

    expect($a->toString())->toBe('<href=STRing;bg=default;options=>string</>');
});

it('sets the text with line-through', function () {
    $a = a('string');

    $a = $a->lineThrough();

    expect($a->toString())->toBe("<href=string;bg=default;options=>\e[9mstring\e[0m</>");
});
