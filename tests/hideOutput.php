<?php

use Symfony\Component\Console\Output\NullOutput;
use function Termwind\hideOutput;
use function Termwind\renderUsing;
use Termwind\Termwind;

it('can hide output', function () {
    hideOutput();

    expect(Termwind::getRenderer())->toBeInstanceOf(NullOutput::class);
});
