<?php

use function Termwind\{br};

it('renders the element', function () {
    $html = parse('<br/>');

    expect($html)->toBe("\n");
});
