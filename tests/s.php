<?php

it('renders the element', function () {
    $html = parse('<u>text</u>');

    expect($html)->toBe("\e[9mtext\e[0m");
});
