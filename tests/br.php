<?php

use function Termwind\{br};

it('renders the element', function () {
    $html = parse('<br/>');

    expect($html)->toBe("\r");
});

it('renders the text with line-breaks', function () {
    $html = parse("<div>line<br/>\n break</div>");

    expect($html)->toBe("line\nbreak");
});
