<?php

use Symfony\Component\Console\Output\BufferedOutput;
use Termwind\HtmlRenderer;
use Termwind\Repositories\Styles;

use function Termwind\renderUsing;

uses()->beforeEach(fn () => renderUsing($this->output = new BufferedOutput))
    ->afterEach(function () {
        renderUsing(null);

        Styles::flush();
    })->in(__DIR__);

/**
 * Parses the given html to string.
 */
function parse(string $html): string
{
    $html = (new HtmlRenderer)->parse($html);

    return $html->toString();
}

/**
 * Gets a input stream resource from a string.
 *
 * @return resource
 */
function getInputStream(string $input = 'answer')
{
    $stream = fopen('php://memory', 'r+', false);
    fwrite($stream, $input);
    rewind($stream);

    return $stream;
}
