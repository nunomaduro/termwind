<?php

use function Termwind\{dl, dt, dd};

it('accepts multiple elements', function () {
    $dl = dl([
        dt('term'),
        dd('details'),
        dt('another term'),
        dd('more details'),
    ]);

    expect($dl->toString())->toBe("<bg=default;options=>\n<bg=default;options=bold>term</>\n    <bg=default;options=>details</>\n<bg=default;options=bold>another term</>\n    <bg=default;options=>more details</></>");
});
