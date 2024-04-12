<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<s>text</s>');

    expect($html)->toBe("\e[9mtext\e[0m");
});
