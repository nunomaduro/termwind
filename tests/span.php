<?php

use function Termwind\{span};

it('renders the element', function () {
    $html = parse('<span>text</span>');

    expect($html)->toBe('<bg=default;options=>text</>');
});
