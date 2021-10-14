<?php

use function Termwind\{div};

it('renders the element', function () {
    $html = parse('<div>text</div>');

    expect($html)->toBe("text\n");
});
