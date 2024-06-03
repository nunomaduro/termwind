<?php

use Termwind\Exceptions\InvalidChild;

use function Termwind\parse;

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

it('renders "li" elements without style', function () {
    $html = parse(<<<'HTML'
        <ul class="list-none">
            <li>list text 1</li>
            <li>list text 2</li>
        </ul>
    HTML);

    expect($html)->toBe("list text 1\nlist text 2");
});

it('renders "li" elements without style in a single row', function () {
    $html = parse(<<<'HTML'
<ul class="list-none"> <li>list item 1.1 test</li> <li>list item 1.2 test</li> <li>list item 1.3 test</li> </ul>
HTML
    );

    expect($html)->toBe("list item 1.1 test \nlist item 1.2 test \nlist item 1.3 test ");
});
