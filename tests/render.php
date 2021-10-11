<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\a;
use function Termwind\div;
use function Termwind\render;
use function Termwind\renderUsing;
use Termwind\HtmlRenderer;

beforeEach(fn () => renderUsing($this->output = new BufferedOutput()));
afterEach(fn () => renderUsing(null));

it('can render from an html string', function () {
    $html = (new HtmlRenderer)->parse('<div>string</div>');

    expect($html->toString())->toBe(div('string')->toString());
});

it('converts class attributes', function () {
    $html = (new HtmlRenderer)->parse('<div class="ml-2 bg-white"><a class="ml-2">foo</a><div><a class="ml-2">foo</a></div>string</div>');

    expect($html->toString())->toBe(div([
        a('foo', 'ml-2'),
        div([a('foo', 'ml-2')]),
        'string',
    ], 'ml-2 bg-white')->toString());
});
