<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="mx-2 my-1 space-y-1">
        <div>
            <span class="bg-green-500 text-black font-bold px-1">Media Queries with <b>Termwind</b>?</span>
            <em class="ml-2">Sure, why not?</em>
        </div>

        <div class="px-1 font-bold bg-blue-500 sm:bg-red-600">
            If bg is blue is small, if red > than small
        </div>
    </div>
HTML);
