<?php

require_once __DIR__ . '/vendor/autoload.php';

use function Termwind\{live};

$counter = 0;

$counter = 0;

$live = live(function () {
    $seconds = date('s');

    return "<p>$seconds</p>";
})->refreshEvery(1);
