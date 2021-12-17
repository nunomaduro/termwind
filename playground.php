<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div>
        <div class="w-full bg-green-300"></div>
        <div class="text-white ml-2">
            🍃 Termwind now supports `w-full`
        </div>
        <div class="w-full bg-green-400"></div>
    </div>
HTML);
