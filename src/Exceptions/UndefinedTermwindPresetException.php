<?php
declare(strict_types=1);

namespace Termwind\Exceptions;

use Exception;

final class UndefinedTermwindPresetException extends Exception
{

    /**
     * An undefined termwind preset exception
     *
     * @param string $presetName
     */
    public function __construct(string $presetName)
    {
        $message = sprintf("%s is not a defined Termwind Preset", $presetName);

        parent::__construct($message);
    }
}
