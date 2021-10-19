<?php

it('renders the element', function () {
    $mdash = html_entity_decode('&mdash;');

    putenv('COLUMNS=10');

    $html = parse('<hr>');

    expect($html)
        ->toContain($mdash)
        ->toBe(str_repeat($mdash, 10));
});
