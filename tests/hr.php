<?php

it('renders the element', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr>');

    expect($html)
        ->toContain('─')
        ->toBe(str_repeat('─', 10));
});

it('can be styled', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr class="text-red">');

    expect($html)->toBe('<fg=red>'.str_repeat('─', 10).'</>');
});

it('accepts the margins and remove from the length', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr class="mx-1 text-red">');

    expect($html)->toBe(' <fg=red>'.str_repeat('─', 8).'</> ');
});


it('accepts width', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr class="w-5 text-red">');

    expect($html)->toBe('<fg=red>'.str_repeat('─', 5).'</>');
});
