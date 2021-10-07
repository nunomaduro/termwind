<?php

use Symfony\Component\Console\Output\BufferedOutput;
use function Termwind\a;
use function Termwind\div;
use function Termwind\renderUsing;
use function Termwind\span;

afterEach(fn () => renderUsing(null));

it('renders a div element with childs', function () {
    renderUsing($output = new BufferedOutput());

    $div = div([
        span('first', 'text-color-white'),
        span('second', 'ml-1 text-color-red'),
        a('link label', 'ml-1 text-color-green')->href('https://github.com'),
    ]);

    expect($div->toString())->toBe('<bg=default;options=><bg=default;fg=white;options=>first</> <bg=default;fg=red;options=>second</> <href=https://github.com;bg=default;fg=green;options=>link label</></>');
});
