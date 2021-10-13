<?php

use Termwind\Exceptions\ColorNotFound;

test('font bold', function () {
    $html = parse('<div class="font-bold">text</div>');

    expect($html)->toBe('<bg=default;options=bold>text</>');
});

test('font light', function () {
    $html = parse('<div class="font-light">text</div>');

    expect($html)->toBe('<bg=default;options=light>text</>');
});

test('italic', function () {
    $html = parse('<div class="italic">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[3mtext\e[0m</>");
});

test('underline', function () {
    $html = parse('<div class="underline">text</div>');

    expect($html)->toBe('<bg=default;options=underscore>text</>');
});

test('pl', function () {
    $html = parse('<div class="pl-2">text</div>');

    expect($html)->toBe('<bg=default;options=>  text</>');
});

test('pr', function () {
    $html = parse('<div class="pr-2">text</div>');

    expect($html)->toBe('<bg=default;options=>text  </>');
});

test('px', function () {
    $html = parse('<div class="px-2">text</div>');

    expect($html)->toBe('<bg=default;options=>  text  </>');
});

test('bg', function () {
    $html = parse('<div class="bg-red">text</div>');

    expect($html)->toBe('<bg=red;options=>text</>');
});

test('bg-color', function () {
    $html = parse('<div class="bg-red-400">text</div>');

    expect($html)->toBe('<bg=#f87171;options=>text</>');
});

test('text-color', function () {
    $html = parse('<div class="text-color-red">text</div>');

    expect($html)->toBe('<bg=default;fg=red;options=>text</>');
});

test('text-color-number', function () {
    $html = parse('<div class="text-color-red-400">text</div>');

    expect($html)->toBe('<bg=default;fg=#f87171;options=>text</>');
});

test('truncate', function () {
    $html = parse(<<<'HTML'
<div>
    <div class="truncate-5">text text</div>
    <div class="truncate-20">text text</div>
</div>
HTML);

    expect($html)->toBe('<bg=default;options=><bg=default;options=>te...</><bg=default;options=>text text</></>');
});

test('width', function () {
    $html = parse(<<<'HTML'
<div>
    <div class="width-5">text text</div>
    <div class="width-10">text text</div>
</div>
HTML);

    expect($html)->toBe('<bg=default;options=><bg=default;options=>text</><bg=default;options=>text text </></>');
});

test('ml', function () {
    $html = parse('<div class="ml-2">text</div>');

    expect($html)->toBe('  <bg=default;options=>text</>');
});

test('mr', function () {
    $html = parse('<div class="mr-2">text</div>');

    expect($html)->toBe('<bg=default;options=>text</>  ');
});

test('mx', function () {
    $html = parse('<div class="mx-2">text</div>');

    expect($html)->toBe('  <bg=default;options=>text</>  ');
});

test('mt', function () {
    $html = parse('<div class="mt-2">text</div>');

    expect($html)->toBe("\n\n<bg=default;options=>text</>");
});

test('mb', function () {
    $html = parse('<div class="mb-2">text</div>');

    expect($html)->toBe("<bg=default;options=>text</>\n\n");
});

test('my', function () {
    $html = parse('<div class="my-2">text</div>');

    expect($html)->toBe("\n\n<bg=default;options=>text</>\n\n");
});

test('m', function () {
    $html = parse('<div class="m-2">text</div>');

    expect($html)->toBe("\n\n  <bg=default;options=>text</>  \n\n");
});

test('uppercase', function () {
    $html = parse('<div class="uppercase">text</div>');

    expect($html)->toBe('<bg=default;options=>TEXT</>');
});

test('lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe('<bg=default;options=>text</>');
});

test('capitalize', function () {
    $html = parse('<div class="capitalize">text text</div>');

    expect($html)->toBe('<bg=default;options=>Text Text</>');
});

test('snakecase', function () {
    $html = parse('<div class="snakecase">TeXt text</div>');

    expect($html)->toBe('<bg=default;options=>te_xt text</>');
});

test('line-through', function () {
    $html = parse('<div class="line-through">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[9mtext\e[0m</>");
});

test('bg-color-number', function () {
    $html = parse('<div class="bg-green-300">text</div>');

    expect($html)->toBe('<bg=#86efac;options=>text</>');
});

test('text-color-color-number', function () {
    $html = parse('<div class="text-color-green-300">text</div>');

    expect($html)->toBe('<bg=default;fg=#86efac;options=>text</>');
});

test('invalid text-color-color-number', function () {
    expect(fn () => parse('<div class="text-color-green-10000">text</div>'))
        ->toThrow(ColorNotFound::class);
});

test('invisible', function () {
    $html = parse('<div class="invisible">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[8mtext\e[0m</>");
});
