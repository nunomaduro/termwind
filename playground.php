<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="w-30 max-w-12 bg-green-600">
        <span class="w-1/2 text-left">
            Left
        </span>
        <span class="w-1/2 text-right">
            Right
        </span>
    </div>
HTML);
