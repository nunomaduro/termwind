<?php

it('renders the element', function () {
    $mdash = html_entity_decode('&mdash;');

    putenv('COLUMNS=10');

    $html = parse('<hr>');

    expect($html)
        ->toContain($mdash)
        ->toBe(str_repeat($mdash, 10));
});

it('can be styled', function () {
    $mdash = html_entity_decode('&mdash;');

    putenv('COLUMNS=10');

    $html = parse('<hr class="text-red">');

    expect($html)
        ->toContain($mdash)
        ->toBe('<fg=red>'.str_repeat($mdash, 10).'</>');
});
