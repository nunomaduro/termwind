<?php

use function Termwind\{span};

it('renders the element', function () {
    $html = parse('<strong>text</strong>');

    expect($html)->toBe("\e[1mtext\e[0m");
});
