<?php

require_once __DIR__.'/vendor/autoload.php';

use function Termwind\render;

render(<<<'HTML'
    <div class="mx-2 my-1">
        <div class="space-y-1">
            <div class="justify-evenly space-x-2 bg-blue-300">
                <span class="px-1 bg-blue-500">A</span>
                <span class="px-1 bg-blue-500">B</span>
                <span class="px-1 bg-blue-500">C</span>
                <span class="px-1 bg-blue-500">C</span>
                <span class="px-1 bg-blue-500">C</span>
                <span class="px-1 bg-blue-500">C</span>
                <span class="px-1 bg-blue-500">C</span>
            </div>
            <div class="justify-between space-x-2 bg-pink-300">
                <span class="px-1 bg-pink-500">A</span>
                <span class="px-1 bg-pink-500">B</span>
                <span class="px-1 bg-pink-500">C</span>
            </div>
            <div class="justify-around space-x-2 bg-purple-300">
                <span class="px-1 bg-purple-500">A</span>
                <span class="px-1 bg-purple-500">B</span>
                <span class="px-1 bg-purple-500">C</span>
            </div>
            <div class="justify-center space-x-2 bg-red-300">
                <span class="px-1 bg-red-500">A</span>
                <span class="px-1 bg-red-500">B</span>
                <span class="px-1 bg-red-500">C</span>
                <span class="px-1 bg-red-500">C</span>
                <span class="px-1 bg-red-500">C</span>
                <span class="px-1 bg-red-500">C</span>
            </div>
        </div>
    </div>
HTML);
