<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<span>text</span>');

    expect($html)->toBe('text');
});

it('empty space shouldn\'t be rendered', function () {
    $html = parse(<<<'HTML'
<div>
    <span class="px-1">hello</span>
    <span class="px-1">world</span>
</div>
HTML
    );

    expect($html)->toBe(' hello  world ');
});

it('sinlge space shouldn\'t be rendered', function () {
    $html = parse(<<<'HTML'
<div>
    <span class="px-1">hello</span> <span class="px-1">world</span>
</div>
HTML
    );

    expect($html)->toBe(' hello   world ');
});
