<?php

declare(strict_types=1);

namespace Termwind\Repositories;

use GdImage;
use Symfony\Component\Mime\MimeTypes;

/**
 * @internal
 */
class ImageReader
{
    private $image;
    private string $imagePath;

    public function __construct(string $imagePath, int $maxWidth, int $maxHeight)
    {
        $inMemoryPath = tempnam('/tmp', $imagePath);
        $img = file_get_contents($imagePath);
        file_put_contents($inMemoryPath, $img);

        if (! is_file($inMemoryPath)) {
            throw new \InvalidArgumentException(sprintf('Image "%s" does not exist', $imagePath));
        }
        if (! is_readable($inMemoryPath)) {
            throw new \InvalidArgumentException(sprintf('Image "%s" is not readable', $imagePath));
        }

        $this->imagePath = $inMemoryPath;
        $mimeType = (new MimeTypes())->guessMimeType($inMemoryPath);

        if (null === $mimeType) {
            throw new \InvalidArgumentException(sprintf('Cannot guess mime type of image "%s"', $imagePath));
        }

        $image = match ($mimeType) {
            'image/png' => imagecreatefrompng($inMemoryPath),
            'image/jpeg' => imagecreatefromjpeg($inMemoryPath),
            'image/gif' => imagecreatefromgif($inMemoryPath),
            'image/vnd.wap.wbmp' => imagecreatefromwbmp($inMemoryPath),
            'image/webp' => imagecreatefromwebp($inMemoryPath),
            default => throw new \InvalidArgumentException(sprintf('Mime type "%s" is not supported', $mimeType)),
        };
        [$width, $height] = getimagesize($this->imagePath);
        [$newWidth, $newHeight] = $this->getScaledDimensions($maxWidth, $maxHeight);

        $this->image = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($this->image, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    }

    /**
     * @return GdImage|bool
     */
    public function getImageInstance(): GdImage|bool
    {
        return $this->image;
    }

    /**
     * @return array<int, int>
     */
    public function getScaledDimensions(int $maxWidth, int $maxHeight): array
    {
        [$width, $height] = getimagesize($this->imagePath);

        return $this->calculate($width, $height, $maxWidth, $maxHeight);
    }

    /**
     * @param  int  $x
     * @param  int  $y
     * @return Rgb
     */
    public function getImagePixel(int $x, int $y): Rgb
    {
        $rgb = imagecolorat($this->image, $x, $y);
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        return new Rgb($r, $g, $b);
    }

    public function calculate(int $width, int $height, int $maxWidth, int $maxHeight): array
    {
        $ratio = $height / $width;

        $newWidth = min($width, $maxWidth);
        $newHeight = $newWidth * $ratio;

        if ($newHeight > $maxHeight) {
            $newWidth = $maxHeight / $ratio;
            $newHeight = $maxHeight;
        }

        return [
            (int) round($newWidth),
            (int) round($newHeight),
        ];
    }
}
