<?php

use Termwind\Exceptions\InvalidChild;

use function Termwind\parse;

it('renders the element', function () {
    $html = parse('<ol><li>list text 1</li></ol>');

    expect($html)->toBe('1. list text 1');
});

it('renders only "li" as children', function () {
    expect(fn () => parse('<ol><div>list text 1</div></ol>'))
        ->toThrow(InvalidChild::class);
});

it('renders "li" elements and ignore empty spaces', function () {
    $html = parse("<ol> <li>list text 1</li>\n\n\n</ol>");

    expect($html)->toBe('1. list text 1');
});

it('renders "li" elements without style in a single row', function () {
    $html = parse(<<<'HTML'
<ol class="list-none"> <li>list item 1.1 test</li> <li>list item 1.2 test</li> <li>list item 1.3 test</li> </ol>
HTML
    );

    expect($html)->toBe("list item 1.1 test \nlist item 1.2 test \nlist item 1.3 test ");
});

it('renders "li" elements without style', function () {
    $html = parse(<<<'HTML'
<ol class="list-none">
    <li>list item 1.1 test</li>
    <li>list item 1.2 test</li>
    <li>list item 1.3 test</li>
</ol>
HTML
    );

    expect($html)->toBe("list item 1.1 test\nlist item 1.2 test\nlist item 1.3 test");
});
