<?php
declare(strict_types=1);

namespace Termwind\Html;

use Symfony\Component\Console\Color;
use Symfony\Component\Console\Terminal;
use Termwind\Components\Element;
use Termwind\Repositories\ImageReader;
use Termwind\Termwind;
use Termwind\ValueObjects\Node;

/**
 * @internal
 */
final class ImageRenderer
{
    /**
     * Highlights HTML content from a given node and converts to the content element.
     */
    public function toElement(Node $node): Element
    {
        $imagePath = $node->getAttribute('image-path');

        $width = max((int) $node->getAttribute('width'), 10);

        $height = max((int) $node->getAttribute('height'), 10);

        $terminal = new Terminal();

        $maxWidth = $width ?? $terminal->getWidth();
        $maxHeight = $height ?? $terminal->getHeight() * 2 - 4;

        $reader = new ImageReader($imagePath, $maxWidth, $maxHeight);

        [$width, $height] = $reader->getScaledDimensions($maxWidth, $maxHeight);

        $output = '';
        for ($y = 0; $y < $height; $y += 2) {
            for ($x = 0; $x < $width; $x++) {
                $bgColor = $reader->getImagePixel($x, $y)->toHex();
                $fgColor = $y + 1 >= $height ? 'black' : $reader->getImagePixel($x, $y + 1)->toHex();
                $output .= (new Color($fgColor, $bgColor))->apply('▄');
            }
            $output .= PHP_EOL;
        }

        return Termwind::raw($output);
    }
}
