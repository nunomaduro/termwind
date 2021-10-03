<?php

use function Termwind\{a};

it('renders an anchor', function () {
    $anchor = a('https://github.com/nunomaduro/termwind');
    $anchorWithValue = a('Termwind');

    $anchorWithValue = $anchorWithValue->href('https://github.com/nunomaduro/termwind');

    expect($anchorWithValue->toString())->toBe('<href=https://github.com/nunomaduro/termwind;bg=default;options=>Termwind</>');
    expect($anchor->toString())->toBe('<href=https://github.com/nunomaduro/termwind;bg=default;options=>https://github.com/nunomaduro/termwind</>');
});
