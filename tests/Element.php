<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\renderUsing;
use function Termwind\span;

afterEach(fn () => renderUsing(null));

it('renders', function () {
    renderUsing($output = new BufferedOutput());

    span('string')->textColor('red')->render();

    expect($output->fetch())->toBe("string");
});
