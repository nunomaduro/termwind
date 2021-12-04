<?php

use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\BufferedOutput;
use Termwind\Events\RefreshEvent;
use Termwind\Exceptions\InvalidRenderer;
use function Termwind\live;
use function Termwind\renderUsing;
use Termwind\Live;

beforeEach(function () {
    renderUsing($this->output = Mockery::mock(ConsoleOutput::class));
});

it('requires symfony console output', function () {
    renderUsing(new BufferedOutput());

    live(fn() => 'foo');
})->throws(InvalidRenderer::class);

it('renders the closure result', function () {
    $section = Mockery::mock(ConsoleSectionOutput::class);
    $section->shouldReceive('write')->once()->with('foo');
    $this->output->shouldReceive('section')->once()->andReturn($section);

    live(fn() => 'foo');
});

it('clears the previous closure result', function () {
    $section = Mockery::mock(ConsoleSectionOutput::class);
    $section->shouldReceive('write')->once()->with('foo');
    $section->shouldReceive('clear')->once();
    $this->output->shouldReceive('section')->once()->andReturn($section);

    live(fn() => 'foo')->clear();
});

it('re-renders the closure result', function () {
    $section = Mockery::mock(ConsoleSectionOutput::class);
    $section->shouldReceive('write')->twice()->with('foo');
    $this->output->shouldReceive('section')->once()->andReturn($section);

    live(fn() => 'foo')->render();
});

it('may be refreshed', function () {
    $section = Mockery::mock(ConsoleSectionOutput::class);
    $section->shouldReceive('write')->twice()->with('foo');
    $section->shouldReceive('clear')->once();
    $this->output->shouldReceive('section')->once()->andReturn($section);

    live(fn() => 'foo')->refresh();
});

it('may be refreshed every X seconds', function () {
    $section = Mockery::mock(ConsoleSectionOutput::class);
    $section->shouldReceive('write')->once()->with(1);
    $section->shouldReceive('write')->once()->with(2);
    $section->shouldReceive('write')->once()->with(3);
    $section->shouldReceive('write')->once()->with(4);
    $section->shouldReceive('clear')->times(3);
    $this->output->shouldReceive('section')->once()->andReturn($section);

    live(function (RefreshEvent $event) {
        static $counter = 0;

        $counter++;

        if ($counter < 5) {
            return $counter;
        }

        $event->stop();
    })->refreshEvery(0);
});
