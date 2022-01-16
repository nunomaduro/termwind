<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="my-1 mx-2 text-black">
        <div class="bg-green-600 px-4 py-1">
            Termwind now supports `py`, `pt` and `pb`
        </div>
    </div>
HTML);
