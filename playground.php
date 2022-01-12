<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="my-1 mx-2">
        <div class="text-white bg-green-800 px-4 py-1">
            Termwind now supports <b>`py`</b>
        </div>
    </div>
HTML);
