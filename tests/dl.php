<?php

use function Termwind\{dl, dt, dd};

it('accepts multiple elements', function () {
    $dl = dl([
        dt('term'),
        dd('details'),
    ]);

    expect($dl->toString())->toBe("<bg=default;options=><bg=default;options=>term</>\n    <bg=default;options=>details</></>");
});
