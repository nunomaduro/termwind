<?php

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Terminal;
use Termwind\Question;

use function Termwind\ask;

function interactiveInput(string $answer = 'answer'): ArrayInput
{
    $input = new ArrayInput([]);
    $input->setStream(getInputStream($answer));
    $input->setInteractive(true);

    return $input;
}

it('receives the answer given from the user', function () {
    Question::setStreamableInput(interactiveInput('this was the answer'));

    $answer = ask('question');
    expect($answer)->toBe('this was the answer');
});

it('renders the question with html', function () {
    Question::setStreamableInput(interactiveInput());

    ask('<span class="bg-red ml-1">Question</span>');

    expect($this->output->fetch())->toBe(' Question');
});

it('renders the question with autocomplete', function () {
    Question::setStreamableInput(interactiveInput('o'));

    $clearLineCode = "\x1b[K";
    $savePositionCode = "\x1b7";
    $restorePositionCode = "\x1b8";

    ask('<span class="bg-red ml-1">Question</span>', ['one', 'two', 'three']);

    expect($this->output->fetch())->toBe(
        ' Question'.'o'.$clearLineCode.$savePositionCode.'ne'.$restorePositionCode
    );
})->skip(! Terminal::hasSttyAvailable(), '`stty` is required to test autocomplete functionality');
