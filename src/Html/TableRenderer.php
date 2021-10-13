<?php

declare(strict_types=1);

namespace Termwind\Html;

use DOMNode;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Termwind\Components\Element;
use Termwind\Termwind;

final class TableRenderer
{
    private Table $table;
    private BufferedOutput $output;
    private string $styles;

    public function __construct(DOMNode $node)
    {
        $this->output = new BufferedOutput(
            // Content should output as is, without changes
            OutputInterface::VERBOSITY_NORMAL | OutputInterface::OUTPUT_RAW,
            true
        );

        $this->table = new Table($this->output);

        $style = $node->getAttribute('style');
        $this->styles = $node->getAttribute('class');

        if (! empty($style)) {
            $this->table->setStyle($style);
        }

        $this->convert($node);
    }

    private function convert(DOMNode $node)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'thead') {
                $this->parseHeader($child);
            }

            if ($child->nodeName === 'tbody') {
                $this->parseBody($child);
            }

            if ($child->nodeName === 'tr') {
                foreach ($this->parseRow($child) as $row) {
                    $this->table->addRow($row);
                }
            }
        }
    }

    private function parseHeader(DOMNode $node)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'tr') {
                foreach ($this->parseRow($child) as $row) {
                    $this->table->setHeaders($row);
                }
            }
        }
    }

    private function parseBody(DOMNode $node)
    {
        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'tr') {
                foreach ($this->parseRow($child) as $row) {
                    $this->table->addRow($row);
                }
            }
        }
    }

    private function parseRow(DOMNode $node): \Iterator
    {
        $row = [];

        foreach ($node->childNodes as $child) {
            if ($child->nodeName === 'th' || $child->nodeName === 'td') {
                $align = $child->getAttribute('align');

                $row[] = new TableCell(
                    // I need only spaces after margin, padding and width except.
                    strip_tags((string) Termwind::span($child->nodeValue, $child->getAttribute('class'))),
                    [
                        // Gets rowspan and colspan from tr and td tag attributes
                        'colspan' => max((int) $child->getAttribute('colspan'), 1),
                        'rowspan' => max((int) $child->getAttribute('rowspan'), 1),

                        // There are background and foreground and options
                        'style' => $this->parseCellStyle(
                            $child->getAttribute('class'),
                            $align === '' ? TableCellStyle::DEFAULT_ALIGN : $align
                        ),
                    ]
                );
            }
        }

        if ($row !== []) {
            yield $row;
        }
    }

    /**
     * Converts table output to the content element.
     */
    public function toElement(): Element
    {
        $this->table->render();

        return Termwind::raw($this->output->fetch());
    }

    /**
     * Parses tr, td tag class attribute and passes bg, fg and options to a table cell style.
     */
    private function parseCellStyle(string $styles, string $align = TableCellStyle::DEFAULT_ALIGN): TableCellStyle
    {
        // I use this empty div for getting styles for bg, fg and options
        // It will be a good idea to get properties without element object and then pass them to an element object
        $element = Termwind::div('', $styles);

        $fg = $element->getProperties()['colors']['fg'] ?? 'default';
        $bg = $element->getProperties()['colors']['bg'] ?? 'default';
        $options = $element->getProperties()['options'] ?? [];

        return new TableCellStyle([
            // Sometimes after recursive array merging fg and bg may contain array instead of string
            'fg' => is_array($fg) ? end($fg) : $fg,
            'bg' => is_array($bg) ? end($bg) : $bg,
            'options' => $options === [] ? null : $options,
            'align' => $align,
        ]);
    }
}
