<?php

use function Termwind\terminal;

it('can get the width of the terminal', function () {
    putenv('COLUMNS=100');

    $width = terminal()->width();

    expect($width)->toBe(100);
});

it('can get the height of the terminal', function () {
    putenv('LINES=30');

    $height = terminal()->height();

    expect($height)->toBe(30);
});

it('can clear the screen', function () {
    terminal()->clear();

    expect($this->output->fetch())->toBe("\ec");
});
