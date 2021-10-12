<?php

use function Termwind\{strong};

it('can render strong', function () {
    $strong = strong('string');

    expect($strong->toString())->toBe('<bg=default;options=bold>string</>');
});
