<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<a>link text</a>');

    expect($html)->toBe('link text');
});

it('renders the href property', function () {
    $html = parse('<a href="url">link text</a>');

    expect($html)->toBe('<href=url>link text</>');
});

it('renders the href with %', function () {
    $html = parse('<a href="someurlwith%s">link text</a>');

    expect($html)->toBe('<href=someurlwith%s>link text</>');
});

it('renders an element with width', function () {
    $html = parse(<<<'HTML'
        <div class="w-10">
            <a href="https://github.com/nunomaduro/termwind">click here</a>
        </div>
    HTML);

    expect($html)->toBe('<href=https://github.com/nunomaduro/termwind>click here</>');
});
