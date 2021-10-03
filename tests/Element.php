<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\renderUsing;
use function Termwind\span;

afterEach(fn () => renderUsing(null));

it('renders', function () {
    renderUsing($output = new BufferedOutput());

    span('string')->textColor('red')->render();

    expect($output->fetch())->toBe("string\n");
});

it('can receive styles as strings', function () {
    renderUsing($output = new BufferedOutput());

    $a = span('string', 'text-color-red bg-white pr-2')->pl(2);
    $b = span('string', 'ml-3 font-bold');

    expect($a->toString())->toBe('<bg=white;fg=red;options=>  string  </>');
    expect($b->toString())->toBe('   <bg=default;options=bold>string</>');
});
