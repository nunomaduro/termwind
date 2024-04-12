<?php

use function Termwind\parse;

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

it('accepts the margins and remove from the length if w-full', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr class="mx-1 text-red">');

    expect($html)->toBe(' <fg=red>'.str_repeat('─', 8).'</> ');
});

it('accepts width', function () {
    putenv('COLUMNS=10');

    $html = parse('<hr class="w-5 mx-2 text-red">');

    expect($html)->toBe('  <fg=red>'.str_repeat('─', 5).'</>  ');
});

it('respects the parent width', function () {
    putenv('COLUMNS=10');

    $html = parse('<div class="mx-2"><hr /></div>');
    expect($html)->toBe('  '.str_repeat('─', 6).'  ');
});
