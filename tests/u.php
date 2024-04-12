<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<u>text</u>');

    expect($html)->toBe("\e[4mtext\e[0m");
});
