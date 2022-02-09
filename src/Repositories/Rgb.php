<?php
declare(strict_types=1);

namespace Termwind\Repositories;

/**
 * This code was originally posted in a comment by @hallboav of this blog post:
 * https://symfony.com/blog/new-in-symfony-5-2-true-colors-in-the-console.
 *
 * @internal
 */
class Rgb
{
    private string $red;
    private string $green;
    private string $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->red = pack('C', $red);
        $this->green = pack('C', $green);
        $this->blue = pack('C', $blue);
    }

    public function toHex(): string
    {
        return sprintf('#%s%s%s', bin2hex($this->red), bin2hex($this->green), bin2hex($this->blue));
    }
}
