<?php

use Symfony\Component\Console\Output\BufferedOutput;
use Termwind\HtmlRenderer;
use function Termwind\{renderUsing};

uses()->beforeEach(fn () => renderUsing($this->output = new BufferedOutput()))
      ->afterEach(fn () => renderUsing(null))
      ->in(__DIR__);

/**
 * Parses the given html to string.
 */
function parse(string $html): string
{
    $html = (new HtmlRenderer)->parse($html);

    return $html->toString();
}
