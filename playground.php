<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="mx-2 my-1">
        <div>🍃 Termwind now supports both <span class="px-1 bg-gray-600">justify-between</span>,
            <span class="px-1 bg-gray-600">justify-around</span> and <span class="px-1 bg-gray-600">justify-evenly</span>.
        </div>
        <div class="max-w-61 w-full">
            <div class="mt-1 font-bold">.justify-between Example</div>
            <div class="justify-between bg-blue-900">
                <span class="px-1 bg-blue-400">1</span>
                <span class="px-1 bg-blue-400">2</span>
                <span class="px-1 bg-blue-400">3</span>
            </div>
            <div class="mt-1 font-bold">.justify-around Example</div>
            <div class="justify-around bg-purple-900">
                <span class="px-1 bg-purple-500">1</span>
                <span class="px-1 bg-purple-500">2</span>
                <span class="px-1 bg-purple-500">3</span>
            </div>
            <div class="mt-1 font-bold">.justify-evenly Example</div>
            <div class="justify-evenly bg-pink-900">
                <span class="px-1 bg-pink-500">1</span>
                <span class="px-1 bg-pink-500">2</span>
                <span class="px-1 bg-pink-500">3</span>
            </div>
        </div>
    </div>
HTML);
