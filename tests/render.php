<?php

use function Termwind\{render};

it('can render complex html', function () {
    $html = parse(<<<'HTML'
        <div class="bg-white">
            <a class="ml-2">link text</a> and <a href="link">link text</a>
        </div>
    HTML
    );

    expect($html)->toBe('<bg=white>  <bg=white>link text</> and <href=link;bg=white>link text</></>');
});

it('can render strings', function () {
    $html = parse('text');

    expect($html)->toBe('text');
});

it('can render style modifier with text modifier', function () {
    $html = parse(<<<'HTML'
        <div class="bg-white underline uppercase">Hello world</div>
    HTML
    );

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

    expect($html)->toBe("<bg=red>Hello <bg=red>\e[1mworld\e[0m</> <href=#;bg=red>click here</></>");
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

it('can inherit styles', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red-300 text-white px-10">
            <span class="mr-1">Hello</span>
            <strong class="text-blue">world</strong>
        </div>
    HTML
    );

    expect($html)->toBe("<bg=#fca5a5;fg=white>          <bg=#fca5a5;fg=white>Hello</> <fg=blue;bg=#fca5a5>\e[1mworld\e[0m</>          </>");
});

it('can extend colors', function () {
    $html = parse(<<<'HTML'
        <div class="my-1 ml-3 px-2 bg-green-300 text-black">
            🍃 Termwind now have the capability to <b>extend</b> colors!
        </div>
    HTML
    );

    expect($html)->toBe("\n   <bg=#86efac;fg=black>  🍃 Termwind now have the capability to <bg=#86efac;fg=black;options=bold>extend</> colors!  </>\n");
});

it('can extend with multiple childs and colors', function () {
    $html = parse(<<<'HTML'
         <div class="my-1 ml-3 px-2 bg-green-300 text-black">
            Termwind <span class="text-red-500"><span class="text-blue-300">now <span class="text-indigo-500">have</span> the</span> capability</span> to extend colors!
        </div>
    HTML
    );

    expect($html)->toBe("\n   <bg=#86efac;fg=black>  Termwind <fg=#ef4444;bg=#86efac><fg=#93c5fd;bg=#86efac>now <fg=#6366f1;bg=#86efac>have</> the</> capability</> to extend colors!  </>\n");
});

it('can inherit styles within multiple levels', function () {
    $html = parse(<<<'HTML'
        <div class="bg-red-700 p-5 my-1 mx-2">
            <div class="text-blue-300 ml-2">
                <div>
                    <div><b>Termwind</b> is great!</div>
                </div>
            </div>
        </div>
    HTML
    );

    expect($html)->toBe("\n  <bg=#b91c1c>       <fg=#93c5fd;bg=#b91c1c><bg=#b91c1c;fg=#93c5fd><bg=#b91c1c;fg=#93c5fd><bg=#b91c1c;fg=#93c5fd;options=bold>Termwind</> is great!</></></>     </>  \n");
});
