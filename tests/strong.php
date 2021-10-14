<?php

use function Termwind\{span};

it('renders the element', function () {
    $html = parse('<strong>text</strong>');

    expect($html)->toBe("\e[1mtext\e[0m");
});

it('renders the element inside another element', function () {
    $html = parse('<div class="bg-red text-color-white">Hello <strong>world</strong></div>');

    expect($html)->toBe("<bg=red;fg=white>Hello \e[1mworld\e[0m</>\n");
});
