<?php

use Termwind\Exceptions\InvalidChild;

it('renders the element', function () {
    $html = parse('<ul><li>list text 1</li></ul>');

    expect($html)->toBe('• list text 1');
});

it('renders only "li" as children', function () {
    expect(fn () => parse('<ul><div>list text 1</div></ul>'))
        ->toThrow(InvalidChild::class);
});

it('renders "li" elements and ignore empty spaces', function () {
    $html = parse(<<<'HTML'
        <ul>
            <li>list text 1</li>
            <li>list text 2</li>
        </ul>
    HTML);

    expect($html)->toBe("• list text 1\n• list text 2");
});
