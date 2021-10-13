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
    $html = (new HtmlRenderer)->parse(<<<'HTML'
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


it('can render table to a string', function () {
    $html = (new HtmlRenderer)->parse(<<<'HTML'
<table style="box">
    <thead>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>4</td>
            <td>9</td>
            <td class="ml-5">6</td>
        </tr>
        <tr>
            <td class="bg-blue text-color-red" align="center">7</td>
            <td colspan="2" align="center">4</td>
        </tr>
        <tr>
            <td class="mx-10">12</td>
            <td>12</td>
            <td align="center">13</td>
        </tr>
    </tbody>
</table>
HTML);

    echo $html->toString();

    expect($html->toString())->toBe(<<<'OUT'
┌────────────────────────┬────┬────────┐
│[39;49m 1                      [39;49m│[39;49m 2  [39;49m│[39;49m 3      [39;49m│
├────────────────────────┼────┼────────┤
│[39;49m 4                      [39;49m│[39;49m 9  [39;49m│[39;49m      6 [39;49m│
│[31;44m           7            [39;49m│[39;49m      4      [39;49m│
│[39;49m           12           [39;49m│[39;49m 12 [39;49m│[39;49m   13   [39;49m│
└────────────────────────┴────┴────────┘

OUT
);
});
