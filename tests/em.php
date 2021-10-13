<?php

it('renders the element', function () {
    $html = parse('<em>text</em>');

    expect($html)->toBe("<bg=default;options=>\e[3mtext\e[0m</>");
});
