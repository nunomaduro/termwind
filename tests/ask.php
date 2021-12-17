<?php

use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
