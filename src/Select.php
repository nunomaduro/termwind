<?php

declare(strict_types=1);

namespace Termwind;

use Closure;
use Symfony\Component\Console\Cursor;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * @internal
 */
final class Select
{
    const KEY_UP = "\033[A";
    const KEY_DOWN = "\033[B";
    const KEY_ENTER = "\n";

    private Cursor $cursor;
    private Closure $refreshCallback;

    /**
     * Creates a new Select instance.
     *
     * @param  array<int, array<string, mixed>>  $options
     */
    public function __construct(
        private Terminal $terminal,
        private ConsoleOutput $output,
        private array $options,
        private Closure $htmlResolver,
        private int $activeIndex = 0
    ) {
        $this->cursor = new Cursor($output);
        $this->refreshCallback = function () {
            return false;
        };
    }

    /**
     * Renders the select.
     */
    public function render(): bool
    {
        $this->cursor->hide();

        $stdin = \defined('STDIN') ? \STDIN : fopen('php://input', 'r+');
        stream_set_blocking($stdin, false);

        $sttyMode = shell_exec('stty -g');
        shell_exec('stty cbreak -echo');

        $live = new Live(
            $this->terminal,
            $this->output->section(),
            new HtmlRenderer(),
            fn() => call_user_func(
                $this->htmlResolver,
                $this->options,
                $this->getActive()
            )
        );

        $live->render();

        while (true) {
            if (! $this->shouldRefresh($key = fgets($stdin))) {
                continue;
            }

            if ($key === self::KEY_ENTER) {
                $this->cursor->show();
                shell_exec(sprintf('stty %s', $sttyMode));

                return true;
            }

            $this->activeIndex = match ($key) {
                self::KEY_UP => max(0, --$this->activeIndex),
                self::KEY_DOWN => min(count($this->options) - 1, ++$this->activeIndex),
                default => $this->activeIndex,
            };

            $live->refresh();
        }
    }

    /**
     * Checks if the content needs to be updated.
     */
    private function shouldRefresh(bool|string $key): bool
    {
        return in_array($key, [self::KEY_ENTER, self::KEY_UP, self::KEY_DOWN], true)
            || call_user_func($this->refreshCallback);
    }

    /**
     * Returns the active selected.
     *
     * @return array<string, mixed>
     */
    public function getActive(): array
    {
        return $this->options[$this->activeIndex];
    }

    /**
     * Sets a callback to run on the infinite loop, to determine if it needs
     * to refresh the content.
     */
    public function shouldRefreshIf(Closure $callback): void
    {
        $this->refreshCallback = $callback;
    }
}
