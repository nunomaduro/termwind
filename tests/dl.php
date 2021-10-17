<?php

it('accepts multiple elements', function () {
    $dl = parse(<<<'HTML'
        <dl>
            <dt>term</dt>
            <dd>details</dd>
            <dt>another term</dt>
            <dd>more details</dd>
        </dl>
    HTML);

    expect($dl)->toBe("<bg=default;options=>\n<bg=default;options=>\e[1mterm\e[0m</>\n    <bg=default;options=>details</>\n<bg=default;options=>\e[1manother term\e[0m</>\n    <bg=default;options=>more details</></>");
});
