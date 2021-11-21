<?php

use Termwind\Exceptions\ColorNotFound;
use Termwind\Exceptions\InvalidStyle;

test('font bold', function () {
    $html = parse('<div class="font-bold">text</div>');

    expect($html)->toBe('<options=bold>text</>');
});

test('strong', function () {
    $html = parse('<div class="strong">text</div>');

    expect($html)->toBe("\e[1mtext\e[0m");
});

test('italic', function () {
    $html = parse('<div class="italic">text</div>');

    expect($html)->toBe("\e[3mtext\e[0m");
});

test('underline', function () {
    $html = parse('<div class="underline">text</div>');

    expect($html)->toBe("\e[4mtext\e[0m");
});

test('pl', function () {
    $html = parse('<div class="pl-2">text</div>');

    expect($html)->toBe('  text');
});

test('pr', function () {
    $html = parse('<div class="pr-2">text</div>');

    expect($html)->toBe('text  ');
});

test('px', function () {
    $html = parse('<div class="px-2">text</div>');

    expect($html)->toBe('  text  ');
});

test('bg', function () {
    $html = parse('<div class="bg-red">text</div>');

    expect($html)->toBe('<bg=red>text</>');
});

test('bg-color', function () {
    $html = parse('<div class="bg-red-400">text</div>');

    expect($html)->toBe('<bg=#f87171>text</>');
});

test('text-color', function () {
    $html = parse('<div class="text-red">text</div>');

    expect($html)->toBe('<fg=red>text</>');
});

test('text-right', function () {
    $html = parse('<div class="w-10 text-right">text</div>');

    expect($html)->toBe('      text');
});

test('truncate', function () {
    $html = parse(<<<'HTML'
        <span>
            <span class="truncate-5">text text</span>
            <span class="truncate-20">text text</span>
        </span>
    HTML);

    expect($html)->toBe('te...text text');
});

test('w', function () {
    $html = parse(<<<'HTML'
        <span>
            <span class="w-5">text-ignored</span>
            <span class="w-10">text text</span>
        </span>
    HTML);

    expect($html)->toBe('text-text text ');
});

test('ml', function () {
    $html = parse('<div class="ml-2">text</div>');

    expect($html)->toBe('  text');
});

test('mr', function () {
    $html = parse('<div class="mr-2">text</div>');

    expect($html)->toBe('text  ');
});

test('mx', function () {
    $html = parse('<div class="mx-2">text</div>');

    expect($html)->toBe('  text  ');
});

test('mt', function () {
    $html = parse('<div class="mt-2">text</div>');

    expect($html)->toBe("\n\ntext");
});

test('mb', function () {
    $html = parse('<div class="mb-2">text</div>');

    expect($html)->toBe("text\n\n");
});

test('my', function () {
    $html = parse('<div class="my-2">text</div>');

    expect($html)->toBe("\n\ntext\n\n");
});

test('m', function () {
    $html = parse('<div class="m-2">text</div>');

    expect($html)->toBe("\n\n  text  \n\n");
});

test('uppercase', function () {
    $html = parse('<div class="uppercase">text</div>');

    expect($html)->toBe('TEXT');
});

test('lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe('text');
});

test('capitalize', function () {
    $html = parse('<div class="capitalize">text text</div>');

    expect($html)->toBe('Text Text');
});

test('snakecase', function () {
    $html = parse('<div class="snakecase">TeXt text</div>');

    expect($html)->toBe('te_xt text');
});

test('line-through', function () {
    $html = parse('<div class="line-through">text</div>');

    expect($html)->toBe("\e[9mtext\e[0m");
});

test('bg-color-number', function () {
    $html = parse('<div class="bg-green-300">text</div>');

    expect($html)->toBe('<bg=#86efac>text</>');
});

test('text-color-number', function () {
    $html = parse('<div class="text-green-300">text</div>');

    expect($html)->toBe('<fg=#86efac>text</>');
});

test('invalid text-color-number', function () {
    expect(fn () => parse('<div class="text-green-10000">text</div>'))
        ->toThrow(ColorNotFound::class);
});

test('invisible', function () {
    $html = parse('<div class="invisible">text</div>');

    expect($html)->toBe("\e[8mtext\e[0m");
});

test('w-full', function () {
    putenv('COLUMNS=10');

    $html = parse('<div class="w-full">text</div>');

    expect($html)->toBe('text      ');
});

test('block', function () {
    $html = parse('<span class="block">Hello <span>World</span></span>');

    expect($html)->toBe('Hello World');

    $html = parse('<span>Hello <span class="block">World</span></span>');

    expect($html)->toBe("Hello \nWorld");
});

test('list-disc', function () {
    $html = parse('<ul class="list-disc"><li>Hello World</li></ul>');

    expect($html)->toBe('• Hello World');
});

test('list-square', function () {
    $html = parse('<ul class="list-square"><li>Hello World</li></ul>');

    expect($html)->toBe('▪ Hello World');
});

test('list-decimal', function () {
    $html = parse('<ol class="list-decimal"><li>Hello World</li></ol>');

    expect($html)->toBe('1. Hello World');
});

test('list-none', function () {
    $html = parse('<ul class="list-none"><li>Hello World</li></ul>');

    expect($html)->toBe('Hello World');
});

test('Invalid use of style list-none', function () {
    expect(fn () => parse('<span class="list-none">Hello <span>World</span></span>'))
        ->toThrow(InvalidStyle::class);
});

test('font-bold, italic and uppercase', function () {
    $html = parse('<div class="font-bold italic uppercase">tExT</div>');

    expect($html)->toBe("<options=bold>\e[3mTEXT\e[0m</>");
});

test('line-through and lowercase', function () {
    $html = parse('<div class="line-through lowercase">TExT</div>');
    expect($html)->toBe("\e[9mtext\e[0m");
});

test('underline and capitalize', function () {
    $html = parse('<div class="underline capitalize">hELLO wORLD</div>');

    expect($html)->toBe("\e[4mHello World\e[0m");
});

test('invisible and snakecase', function () {
    $html = parse('<div class="invisible snakecase">textTEXT</div>');

    expect($html)->toBe("\e[8mtext_text\e[0m");
});

test('width, bg, text-right', function () {
    $html = parse(<<<'HTML'
        <div class="w-15 text-right">
            <span class="bg-green-500">Pass</span>
            <span class="text-gray-200">Some Text</span>
        </div>
    HTML);

    expect($html)->toBe("  <bg=#22c55e>Pass</><fg=#e5e7eb>Some Text</>");
});

test('append-text', function () {
    $html = parse('<div class="append-world">hello</div>');

    expect($html)->toBe('helloworld');
});
