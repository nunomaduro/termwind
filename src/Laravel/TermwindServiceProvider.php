<?php

declare(strict_types=1);

namespace Termwind\Laravel;

use Illuminate\Support\ServiceProvider;
use Termwind\Termwind;

final class TermwindServiceProvider extends ServiceProvider
{
    /**
     * Sets the the renderer used for unit testing.
     */
    public function register(): void
    {
        if ($this->app->runningUnitTests()) {
            Termwind::renderUsing(new TestingBufferedOutput($this->app));
        }
    }
}
