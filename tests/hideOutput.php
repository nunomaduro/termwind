<?php

use Symfony\Component\Console\Output\NullOutput;
use function Termwind\hideOutput;
use Termwind\Termwind;

it('can hide output', function () {
    hideOutput();

    expect(Termwind::getRenderer())->toBeInstanceOf(NullOutput::class);
});
