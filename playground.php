<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="mx-2 my-1 space-y-1">
        <div class="px-2 font-bold text-black bg-purple-500">Working on some new features for 🍃 Termwind!</div>
        <div>
            <div class="flex space-x-1">
                <span>Add <b><i>.flex</i></b> and <b><i>.flex-1</i></b> support</span>
                <span class="flex-1 text-gray content-repeat-['.']"></span>
                <span class="text-green">✓ Done</span>
            </div>
            <div class="flex space-x-1">
                <span>Add <b><i>.content-repeat-['-.']</i></b> support</span>
                <span class="flex-1 text-gray content-repeat-['-.']"></span>
                <span class="text-green">✓ Done</span>
            </div>
        </div>
    </div>
HTML);
