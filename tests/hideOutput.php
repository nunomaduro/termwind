<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\hideOutput;
use function Termwind\renderUsing;
use Termwind\Termwind;

beforeEach(fn () => renderUsing(null));

it('can hide output', function () {
    hideOutput();

    expect(Termwind::getRenderer())->toBeInstanceOf(BufferedOutput::class);
});
