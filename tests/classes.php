<?php

use Termwind\Exceptions\ColorNotFound;

test('font bold', function () {
    $html = parse('<div class="font-bold">text</div>');

    expect($html)->toBe("\e[1mtext\e[0m\n");
});

test('italic', function () {
    $html = parse('<div class="italic">text</div>');

    expect($html)->toBe("\e[3mtext\e[0m\n");
});

test('underline', function () {
    $html = parse('<div class="underline">text</div>');

    expect($html)->toBe("\e[4mtext\e[0m\n");
});

test('pl', function () {
    $html = parse('<div class="pl-2">text</div>');

    expect($html)->toBe("  text\n");
});

test('pr', function () {
    $html = parse('<div class="pr-2">text</div>');

    expect($html)->toBe("text  \n");
});

test('px', function () {
    $html = parse('<div class="px-2">text</div>');

    expect($html)->toBe("  text  \n");
});

test('bg', function () {
    $html = parse('<div class="bg-red">text</div>');

    expect($html)->toBe("<bg=red>text</>\n");
});

test('bg-color', function () {
    $html = parse('<div class="bg-red-400">text</div>');

    expect($html)->toBe("<bg=#f87171>text</>\n");
});

test('text-color', function () {
    $html = parse('<div class="text-color-red">text</div>');

    expect($html)->toBe("<fg=red>text</>\n");
});

test('text-color-number', function () {
    $html = parse('<div class="text-color-red-400">text</div>');

    expect($html)->toBe("<fg=#f87171>text</>\n");
});

test('truncate', function () {
    $html = parse(<<<'HTML'
<div class="truncate-5">text text</div>
<div class="truncate-20">text text</div>
HTML);

    expect($html)->toBe("te...\ntext text\n");
});

test('width', function () {
    $html = parse(<<<'HTML'
<div class="width-5">text text</div>
<div class="width-10">text text</div>
HTML);

    expect($html)->toBe("text\ntext text \n");
});

test('ml', function () {
    $html = parse('<div class="ml-2">text</div>');

    expect($html)->toBe("  text\n");
});

test('mr', function () {
    $html = parse('<div class="mr-2">text</div>');

    expect($html)->toBe("text  \n");
});

test('mx', function () {
    $html = parse('<div class="mx-2">text</div>');

    expect($html)->toBe("  text  \n");
});

test('mt', function () {
    $html = parse('<div class="mt-2">text</div>');

    expect($html)->toBe("\n\ntext\n");
});

test('mb', function () {
    $html = parse('<div class="mb-2">text</div>');

    expect($html)->toBe("text\n\n\n");
});

test('my', function () {
    $html = parse('<div class="my-2">text</div>');

    expect($html)->toBe("\n\ntext\n\n\n");
});

test('m', function () {
    $html = parse('<div class="m-2">text</div>');

    expect($html)->toBe("\n\n  text  \n\n\n");
});

test('uppercase', function () {
    $html = parse('<div class="uppercase">text</div>');

    expect($html)->toBe("TEXT\n");
});

test('lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe("text\n");
});

test('capitalize', function () {
    $html = parse('<div class="capitalize">text text</div>');

    expect($html)->toBe("Text Text\n");
});

test('snakecase', function () {
    $html = parse('<div class="snakecase">TeXt text</div>');

    expect($html)->toBe("te_xt text\n");
});

test('line-through', function () {
    $html = parse('<div class="line-through">text</div>');

    expect($html)->toBe("\e[9mtext\e[0m\n");
});

test('bg-color-number', function () {
    $html = parse('<div class="bg-green-300">text</div>');

    expect($html)->toBe("<bg=#86efac>text</>\n");
});

test('text-color-color-number', function () {
    $html = parse('<div class="text-color-green-300">text</div>');

    expect($html)->toBe("<fg=#86efac>text</>\n");
});

test('invalid text-color-color-number', function () {
    expect(fn () => parse('<div class="text-color-green-10000">text</div>'))
        ->toThrow(ColorNotFound::class);
});

test('invisible', function () {
    $html = parse('<div class="invisible">text</div>');

    expect($html)->toBe("\e[8mtext\e[0m\n");
});

test('w-full', function () {
    putenv('COLUMNS=10');

    $html = parse('<div class="w-full">text</div>');

    expect($html)->toBe('<bg=default;options=>text      </>');
});
