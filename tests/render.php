<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\a;
use function Termwind\div;
use Termwind\HtmlRenderer;
use function Termwind\renderUsing;

beforeEach(fn () => renderUsing($this->output = new BufferedOutput()));
afterEach(fn () => renderUsing(null));

it('can render from an html string', function () {
    $html = (new HtmlRenderer)->parse('<div>string</div>');

    expect($html->toString())->toBe(div('string')->toString());
});

it('converts attributes', function () {
    $html = (new HtmlRenderer)->parse(<<<HTML
<div class="bg-white">
    <a class="ml-2">foo</a>
    <a class="ml-2" href="bar">foo</a>
</div>
HTML);

    expect($html->toString())->toBe(div([
        a('foo', 'ml-2'),
        a('foo', 'ml-2')->href('bar'),
    ], 'bg-white')->toString());
});


