<?php

use Termwind\Actions\StyleToMethod;

it('supports styling', function ($name) {
    putenv('COLUMNS=' . StyleToMethod::MEDIA_QUERIES_BREAKPOINTS[$name]);

    $html = parse(<<<HTML
        <div class="w-full {$name}:w-1"></div>
    HTML);

    expect($html)->toBe(' ');
})->with(array_keys(StyleToMethod::MEDIA_QUERIES_BREAKPOINTS));

it('renders based on the size even if the styles are in the wrong order', function () {
    putenv('COLUMNS=64');

    $html = parse(<<<'HTML'
        <div class="md:bg-blue lg:bg-purple sm:bg-red bg-green">
            Test
        </div>
    HTML);

    expect($html)->toBe('<bg=red>Test</>');

});
