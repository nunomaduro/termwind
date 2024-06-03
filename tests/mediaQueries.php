<?php

use Termwind\Actions\StyleToMethod;

use function Termwind\parse;

it('supports styling', function ($name) {
    putenv('COLUMNS='.StyleToMethod::MEDIA_QUERY_BREAKPOINTS[$name]);

    $html = parse(<<<HTML
        <div class="w-full {$name}:w-1"></div>
    HTML);

    expect($html)->toBe(' ');
})->with(array_keys(StyleToMethod::MEDIA_QUERY_BREAKPOINTS));

it('renders based on the size even if the styles are in the wrong order', function () {
    putenv('COLUMNS=64');

    $html = parse(<<<'HTML'
        <div class="md:bg-blue lg:bg-purple sm:bg-red bg-green">
            Test
        </div>
    HTML);

    expect($html)->toBe('<bg=red>Test</>');
});

it('resets the width when the breakpoint is reached', function () {
    putenv('COLUMNS=64');

    $html = parse(<<<'HTML'
        <div class="w-2 sm:w-auto">text</div>
    HTML);

    expect($html)->toBe('text');
});
