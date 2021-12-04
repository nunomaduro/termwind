<?php

declare(strict_types=1);

namespace Termwind\Events;

final class RefreshEvent
{
    /**
     * If the Live refresh should stop.
     *
     * @internal
     */
    public bool $stop = false;

    /**
     * Stops refreshing the html.
     */
    public function stop(): void
    {
        $this->stop = true;
    }
}
