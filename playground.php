<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\{render, live, select};

render(<<<HTML
    <div class="mx-2 my-1 px-2 bg-blue text-black">
        Who is the author of <b>Laravel</b>?
    </div>
HTML);

$options = [[
    'value' => '@enunomaduro',
    'label' => 'Nuno Maduro',
], [
    'value' => '@calebporzio',
    'label' => 'Caleb Porzio',
], [
    'value' => '@taylorotwell',
    'label' => 'Taylor Otwell',
], [
    'value' => '@adamwathan',
    'label' => 'Adam Wathan',
]];

$select = select(function ($options, $active) {
    $html = '';

    foreach ($options as $option) {
        if ($active['value'] === $option['value']) {
            $html .= '<div><b class="text-green">✔</b> ' . $option['label'] . ' - ' . date('i:s') . '</div>';
        } else {
            $html .= '<div>- ' . $option['label'] . ' - ' . date('i:s') . '</div>';
        }
    }

    return "<div class='mx-2'>$html</div>";
}, $options);

$time = microtime(true);
$select->shouldRefreshIf(function () use (&$time) {
    if ((microtime(true) - $time) > 1) {
        $time = microtime(true);
        return true;
    }

    return false;
});

$select->render();

if ($select->getActive()['value'] === '@taylorotwell') {
    render(<<<HTML
        <div class="my-1 mx-2 px-2 bg-green text-black">
            🎂 That's correct <i>@taylorotwell</i> is the author of <b>Laravel</b>!
        </div>
    HTML);
}
