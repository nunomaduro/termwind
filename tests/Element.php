<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\line;
use function Termwind\renderUsing;

afterEach(fn () => renderUsing(null));

it('renders', function () {
    renderUsing($output = new BufferedOutput());

    line('string')->textColor('red')->render();

    expect($output->fetch())->toBe("string\n");
});

it('can receive styles as strings', function () {
    renderUsing($output = new BufferedOutput());

    $a = line('string', 'text-color-red bg-white pr-2')->pl2();
    $b = line('string', 'ml-3 font-bold');

    expect($a->toString())->toBe('<bg=white;fg=red;options=>  string  </>');
    expect($b->toString())->toBe('   <bg=default;options=bold>string</>');
});
