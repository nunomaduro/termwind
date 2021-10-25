<?php

it('renders the element', function () {
    $html = parse('<div>text</div>');

    expect($html)->toBe('text');
});

it('renders the element with display block as default', function () {
    $html = parse(<<<'HTML'
        <div>
            <div></div>
            <div>Second Line</div>
        </div>
    HTML);

    expect($html)->toBe(" \nSecond Line");
});
