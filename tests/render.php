<?php

use function Termwind\{render};

it('can render complex html', function () {
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

it('renders element inside another one', function () {
    $html = parse('<div>Hello <strong>world</strong></div>');

    expect($html)->toBe("<bg=default;options=>Hello <bg=default;options=>\e[1mworld\e[0m</></>");
});

it('renders element inside another one with extra spaces and line breaks', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red">
            Hello
            <strong>world</strong>
        </div>
    HTML);

    expect($html)->toBe("<bg=red;options=>Hello <bg=default;options=>\e[1mworld\e[0m</></>");
});
