<?php

it('renders the element', function () {
    $html = parse('<p>text</p>');

    expect($html)->toBe("\ntext\n");
});
