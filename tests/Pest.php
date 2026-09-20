<?php

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\BufferedOutput;
use Termwind\Repositories\Styles;

use function Termwind\renderUsing;

uses()->beforeEach(fn () => renderUsing($this->output = new BufferedOutput))
    ->afterEach(function () {
        renderUsing(null);

        Styles::flush();
    })->in(__DIR__);

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

/**
 * Determines if Symfony's table aligns separator crossings with adjacent rows.
 */
function tableSeparatorsAlign(): bool
{
    $output = new BufferedOutput;

    (new Table($output))
        ->setStyle('box')
        ->setRows([['a', 'b'], new TableSeparator, [new TableCell('c', ['colspan' => 2])]])
        ->render();

    return str_contains(explode("\n", $output->fetch())[2], '┴');
}
