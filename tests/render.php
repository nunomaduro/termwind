<?php

it('can render complext html', function () {
    $html = parse(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">foo</a>
    <a class="ml-2" href="bar">foo</a>
</div>
HTML);

    expect($html)->toBe('<bg=white;options=>  <href=foo;bg=default;options=>foo</>  <href=bar;bg=default;options=>foo</></>');
});
