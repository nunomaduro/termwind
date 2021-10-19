<?php

use function Termwind\{render};

it('can render complex html', function () {
    $html = parse(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">link text</a>
    <a class="ml-2" href="link">link text</a>
</div>
HTML);

    expect($html)->toBe('<bg=white>  link text  <href=link;bg=white>link text</></>');
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

it('can render style modifier with text modifier', function () {
    $html = parse(<<<'HTML'
<div class="bg-white underline uppercase">Hello world</div>
HTML);

    expect($html)->toBe("<bg=white>\e[4mHELLO WORLD\e[0m</>");
});

it('inherit styles', function () {
    $html = parse(<<<'HTML'
    <div class="bg-red-300 text-color-white px-10">
        <span class="mr-1">Hello</span>
        <strong class="text-color-blue">world</strong>
    </div>
HTML);

    expect($html)->toBe("<bg=#fca5a5;fg=white>          Hello <fg=blue;bg=#fca5a5>\e[1mworld\e[0m</>          </>");
});
