<?php

use Symfony\Component\Console\Formatter\NullOutputFormatter;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;
use Termwind\Question;

use function Termwind\ask;
use function Termwind\renderUsing;

it('receives the answer given from the user', function () {
    $inputStream = getInputStream('this was the answer');
    Question::setStreamableInput($input = Mockery::mock(StreamableInputInterface::class));

    $input->shouldReceive('getStream')->once()->andReturn($inputStream);
    $input->shouldReceive('isInteractive')->once()->andReturn(true);

    $answer = ask('question');
    expect($answer)->toBe('this was the answer');
});

it('renders the question with html', function () {
    $inputStream = getInputStream();
    Question::setStreamableInput($input = Mockery::mock(StreamableInputInterface::class));

    $input->shouldReceive('getStream')->once()->andReturn($inputStream);
    $input->shouldReceive('isInteractive')->once()->andReturn(true);

    renderUsing($output = Mockery::mock(OutputInterface::class));

    $output->shouldReceive('write')->once()->with(' <bg=red>Question</>');
    $answer = ask('<span class="bg-red ml-1">Question</span>');
});

it('renders the question with autocomplete', function () {
    $inputStream = getInputStream('o');
    Question::setStreamableInput($input = Mockery::mock(StreamableInputInterface::class));

    $input->shouldReceive('getStream')->once()->andReturn($inputStream);
    $input->shouldReceive('isInteractive')->once()->andReturn(true);

    renderUsing($output = Mockery::mock(OutputInterface::class));

    $clearLineCode = "\x1b[K";
    $savePositionCode = "\x1b7";
    $restorePositionCode = "\x1b8";

    $output->shouldReceive('write')->once()->with(' <bg=red>Question</>');
    $output->shouldReceive('write')->once()->with('o');
    $output->shouldReceive('write')->once()->with($savePositionCode);
    $output->shouldReceive('write')->once()->with($clearLineCode);
    $output->shouldReceive('write')->once()->with('<hl>ne</hl>');
    $output->shouldReceive('write')->once()->with($restorePositionCode);
    $output->shouldReceive('getFormatter')->once()->andReturn(new NullOutputFormatter);

    ask('<span class="bg-red ml-1">Question</span>', ['one', 'two', 'three']);
})->skip(! Terminal::hasSttyAvailable(), '`stty` is required to test autocomplete functionality');
