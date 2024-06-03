<?php

use Termwind\Exceptions\InvalidChild;

use function Termwind\parse;

it('accepts multiple elements', function () {
    $dl = parse(<<<'HTML'
        <dl>
            <dt>term</dt>
            <dd>details</dd>
            <dt>another term</dt>
            <dd>more details</dd>
        </dl>
    HTML
    );

    expect($dl)->toBe("<options=bold>term</>\n    details\n<options=bold>another term</>\n    more details");
});

it('renders only "dt" and "dd" as children', function () {
    expect(fn () => parse('<dl><h1></h1></dl>'))
        ->toThrow(InvalidChild::class);
});

it('renders "dt" and "dd" elements and ignore empty spaces', function () {
    $html = parse(<<<'HTML'
        <dl>

            <dt>term</dt>
            <dd>details</dd>
            <dt>another term</dt>

            <dd>more details</dd>

        </dl>
    HTML
    );

    expect($html)->toBe("<options=bold>term</>\n    details\n<options=bold>another term</>\n    more details");
});

it('renders "dt" and "dd" in a single row', function () {
    $html = parse(<<<'HTML'
        <dl> <dt>term</dt> <dd>details</dd> </dl>
    HTML
    );

    expect($html)->toBe("<options=bold>term</> \n    details ");
});
