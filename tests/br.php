<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<br/>');

    expect($html)->toBe("\r");
});

it('renders the text with line-breaks', function () {
    $html = parse("<div>line<br/>\n break</div>");

    expect($html)->toBe("line\nbreak");
});

it('does not render if class hidden is added', function () {
    $html = parse("<div>A<br class='hidden' />B</div>");

    expect($html)->toBe('AB');
});

it('only renders one line break if the block class is added', function () {
    $html = parse("<div>A<br class='block' />B</div>");

    expect($html)->toBe("A\nB");
});
