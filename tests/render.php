<?php

use function Termwind\{render};

it('can render complex html', function () {
    $html = parse(<<<'HTML'
        <div class="bg-white">
            <a class="ml-2">link text</a> and <a href="link">link text</a>
        </div>
    HTML
    );

    expect($html)->toBe('<bg=white>  link text and <href=link;bg=white>link text</></>');
});

it('can render strings', function () {
    $html = parse('text');

    expect($html)->toBe('text');
});

it('can render style modifier with text modifier', function () {
    $html = parse(<<<'HTML'
        <div class="bg-white underline uppercase">Hello world</div>
    HTML);

    expect($html)->toBe("<bg=white>\e[4mHELLO WORLD\e[0m</>");
});

it('can render to custom output', function () {
    $html = render(<<<'HTML'
        <div class="bg-white">
            <a class="ml-2">link text</a><a class="ml-2" href="link">link text</a>
        </div>
    HTML
    );

    expect($this->output->fetch())->toBe("  link text  link text\n");
});

it('renders element inside another one', function () {
    $html = parse('<div>Hello <strong>world</strong></div>');

    expect($html)->toBe("Hello \e[1mworld\e[0m");
});

it('renders element inside another one with extra spaces and line breaks', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red">
            Hello <strong>world</strong> <a href="#">click here</a>
        </div>
    HTML
    );

    expect($html)->toBe("<bg=red>Hello \e[1mworld\e[0m <href=#;bg=red>click here</></>");
});

it('renders element and ignores the classes of the same type', function () {
    $html = parse(<<<'HTML'
        <div class="ml-3 ml-1">Hello World</div>
    HTML
    );

    expect($html)->toBe(' Hello World');
});

it('does not render comment html strings', function () {
    $html = parse(<<<'HTML'
        <div>
            <!-- This is a comment -->
            <div>Hello World</div>
        </div>
    HTML
    );

    expect($html)->toBe('Hello World');
});

it('inherit styles', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red-300 text-white px-10">
            <span class="mr-1">Hello</span>
            <strong class="text-blue">world</strong>
        </div>
    HTML);

    expect($html)->toBe("<bg=#fca5a5;fg=white>          Hello <fg=blue;bg=#fca5a5>\e[1mworld\e[0m</>          </>");
});
