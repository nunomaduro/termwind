<?php

declare(strict_types=1);

namespace Termwind\Laravel;

use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Console\Output\BufferedOutput;

final class TestingBufferedOutput extends BufferedOutput {

    /* @phpstan-ignore-next-line */
    public function __construct(private Application $app)
    {
        parent::__construct(null, false, null);
    }

    /**
     * {@inheritdoc}
     */
    public function doWrite(string $message, bool $newline): void
    {
        $this->app->make(OutputStyle::class)->getOutput()->doWrite($message, $newline);
    }
}
