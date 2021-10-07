<?php

use function Termwind\{br};

it('adds a new line', function () {
    $br = br();

    expect($br->toString())->toBe("<bg=default;options=></>\n");
});
