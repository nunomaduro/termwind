<?php
use Symfony\Component\Console\Output\BufferedOutput;
use Termwind\Termwind;
use function Termwind\{hideOutput, renderUsing};

beforeEach(fn () => renderUsing(null));

it('can hide output', function () {
    hideOutput();

    expect(Termwind::getRenderer())->toBeInstanceOf(BufferedOutput::class);
});
