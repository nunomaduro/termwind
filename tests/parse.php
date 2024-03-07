<?php

it('parses html as a string', function () {
    $html = \Termwind\parse(<<<'HTML'
        <div class="bg-white underline uppercase">Hello world</div>
    HTML);

    expect($html)->toBe("<bg=white>\e[4mHELLO WORLD\e[0m</>");
});

it('parses a string as a string', function () {
    $html = \Termwind\parse('text');

    expect($html)->toBe('text');
});
