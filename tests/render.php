<?php

use function Termwind\{render};

it('can render complext html', function () {
    $html = parse(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">link text</a>
    <a class="ml-2" href="link">link text</a>
</div>
HTML);

    expect($html)->toBe('<bg=white>  link text  <href=link>link text</></>');
});

it('can render strings', function () {
    $html = parse('text');

    expect($html)->toBe('text');
});

it('can render to custom output', function () {
    $html = render(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">link text</a>
    <a class="ml-2" href="link">link text</a>
</div>
HTML);

    expect($this->output->fetch())->toBe("  link text  link text\n");
});
