<?php

use Termwind\Exceptions\UndefinedTermwindPresetException;
use Termwind\Preset;
use function Termwind\line;
use function Termwind\register_preset;
use function Termwind\render_preset;

/**
 * after each test clear the predefined presets
 */
afterEach(fn() => Preset::$presets = []);


it('register a preset', function () {
    Preset::register('primary-design', function ($message) {
        return line($message)->bg('blue');
    });

    expect(count(Preset::$presets))->toBe(1);
});

it('register a preset by function', function () {
    register_preset('primary-design', function ($message) {
        return line($message)->bg('blue');
    });

    expect(count(Preset::$presets))->toBe(1);
});


it('use a preset', function () {
    Preset::register('primary-design', function ($message) {
        return line($message)->bg('blue');
    });

    $output = Preset::design('arsan', 'primary-design');

    expect($output->toString())->toBe('<bg=blue;options=>arsan</>');
});

it('use a preset by function', function () {
    register_preset('primary-design', function ($message) {
        return line($message)->bg('blue');
    });

    $output = render_preset('arsan', 'primary-design');

    expect($output->toString())->toBe('<bg=blue;options=>arsan</>');
});

it('cant use a non-existent preset', function(){
    $output = Preset::design("some message",'some-preset');
})->throws(UndefinedTermwindPresetException::class);


