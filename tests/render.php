<?php

use function Termwind\{render};

it('can render complext html', function () {
    $html = parse(<<<'HTML'
<div class="bg-white">
    <a class="ml-2">link text</a>
    <a class="ml-2" href="link">link text</a>
</div>
HTML);

    expect($html)->toBe('<bg=white;options=>  <bg=default;options=>link text</>  <href=link;bg=default;options=>link text</></>');
});

it('can render strings', function () {
    $html = parse('text');

    expect($html)->toBe('<bg=default;options=>text</>');
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
