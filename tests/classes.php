<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\a;
use function Termwind\div;
use Termwind\HtmlRenderer;
use function Termwind\renderUsing;

it('adds font bold', function () {
    $html = parse('<div class="font-bold">text</div>');

    expect($html)->toBe('<bg=default;options=bold>text</>');
});

it('adds an italic style', function () {
    $html = parse('<div class="italic">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[3mtext\e[0m</>");
});

it('adds underline', function () {
    $html = parse('<div class="underline">text</div>');

    expect($html)->toBe('<bg=default;options=underscore>text</>');
});

it('adds padding left', function () {
    $html = parse('<div class="pl-2">text</div>');

    expect($html)->toBe('<bg=default;options=>  text</>');
});

it('adds padding right', function () {
    $html = parse('<div class="pr-2">text</div>');

    expect($html)->toBe('<bg=default;options=>text  </>');
});

it('adds horizontal padding', function () {
    $html = parse('<div class="px-2">text</div>');

    expect($html)->toBe('<bg=default;options=>  text  </>');
});

it('adds background color', function () {
    $html = parse('<div class="bg-red">text</div>');

    expect($html)->toBe('<bg=red;options=>text</>');
});

it('adds background color using color enum', function () {
    $html = parse('<div class="bg-red-400">text</div>');

    expect($html)->toBe('<bg=#f87171;options=>text</>');
});

it('adds text color', function () {
    $html = parse('<div class="text-color-red">text</div>');

    expect($html)->toBe('<bg=default;fg=red;options=>text</>');
});

it('adds text color using color enum', function () {
    $html = parse('<div class="text-color-red-400">text</div>');


    expect($html)->toBe('<bg=default;fg=#f87171;options=>text</>');
});

it('truncates', function () {
    $html = parse('<div class="truncate-5">text text</div>');

    expect($html)->toBe('<bg=default;options=>te...</>');
});

it('adds width', function () {
    $html = parse('<div class="width-10">text text</div>');

    expect($html)->toBe('<bg=default;options=>text text </>');
});

it('adds margin left', function () {
    $html = parse('<div class="ml-2">text</div>');

    expect($html)->toBe('  <bg=default;options=>text</>');
});

it('adds margin right', function () {
    $html = parse('<div class="mr-2">text</div>');

    expect($html)->toBe('<bg=default;options=>text</>  ');
});

it('adds horizontal margin', function () {
    $html = parse('<div class="mx-2">text</div>');

    expect($html)->toBe('  <bg=default;options=>text</>  ');
});

it('adds margin top', function () {
    $html = parse('<div class="mt-2">text</div>');

    expect($html)->toBe("\n\n<bg=default;options=>text</>");
});

it('adds margin bottom', function () {
    $html = parse('<div class="mb-2">text</div>');

    expect($html)->toBe("<bg=default;options=>text</>\n\n");
});

it('adds vertical margin', function () {
    $html = parse('<div class="my-2">text</div>');

    expect($html)->toBe("\n\n<bg=default;options=>text</>\n\n");
});

it('adds margin', function () {
    $html = parse('<div class="m-2">text</div>');

    expect($html)->toBe("\n\n  <bg=default;options=>text</>  \n\n");
});

it('sets the text uppercase', function () {
    $html = parse('<div class="uppercase">text</div>');

    expect($html)->toBe('<bg=default;options=>TEXT</>');
});

it('sets the text lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe('<bg=default;options=>text</>');
});

it('sets the text capitalize', function () {
    $html = parse('<div class="capitalize">text text</div>');

    expect($html)->toBe('<bg=default;options=>Text Text</>');
});

it('sets the text in snakecase', function () {
    $html = parse('<div class="snakecase">TeXt text</div>');

    expect($html)->toBe('<bg=default;options=>te_xt text</>');
});

it('sets the text with line-through', function () {
    $html = parse('<div class="line-through">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[9mtext\e[0m</>");
});

it('can receive bg-color class names as string', function () {
    $html = parse('<div class="bg-green-300">text</div>');

    expect($html)->toBe('<bg=#86efac;options=>text</>');
});

it('can receive text-color class names as string', function () {
    $html = parse('<div class="text-color-green-300">text</div>');

    expect($html)->toBe('<bg=default;fg=#86efac;options=>text</>');
});

it('hides the text', function () {
    $html = parse('<div class="invisible">text</div>');

    expect($html)->toBe("<bg=default;options=>\e[8mtext\e[0m</>");
});
