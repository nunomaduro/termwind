<?php

use function Termwind\parse;

it('renders the element', function () {
    $html = parse(<<<'HTML'
        <div>
            <code start-line="11400">&lt;?php</code>
        </div>
HTML
    );

    expect($html)->toBe(<<<'HTML'

<fg=gray>11400</><fg=gray>▕ </>[1m<?php[0m
HTML
    );
});

it('renders the element with multiline code', function () {
    $html = parse(<<<'HTML'
        <div>
            <code line="7">
&lt;?php

/** @test */
function sentryReport()
{
    try {
        throw new \Exception('Something went wrong');
    } catch (\Throwable $e) {
        report($e);
    }
}
            </code>
        </div>
HTML
    );

    expect($html)->toBe(<<<'HTML'

    <fg=gray>  1</><fg=gray>▕ </>[1m<?php[0m
    <fg=gray>  2</><fg=gray>▕ </>
    <fg=gray>  3</><fg=gray>▕ </><fg=gray>[3m/** @test */[0m</>
    <fg=gray>  4</><fg=gray>▕ </><fg=magenta>[1mfunction [0m</>[1msentryReport[0m<fg=magenta>[1m()[0m</>
    <fg=gray>  5</><fg=gray>▕ </><fg=magenta>[1m{[0m</>
    <fg=gray>  6</><fg=gray>▕ </><fg=magenta>[1m    try {[0m</>
<fg=red>[1m  ➜ [0m</>[1m[3m  7[0m[0m<fg=gray>▕ </><fg=magenta>[1m        throw new \Exception([0m</><fg=gray>'Something went wrong'</><fg=magenta>[1m);[0m</>
    <fg=gray>  8</><fg=gray>▕ </><fg=magenta>[1m    } catch (\Throwable [0m</>[1m$e[0m<fg=magenta>[1m) {[0m</>
    <fg=gray>  9</><fg=gray>▕ </><fg=magenta>[1m        [0m</>[1mreport[0m<fg=magenta>[1m([0m</>[1m$e[0m<fg=magenta>[1m);[0m</>
    <fg=gray> 10</><fg=gray>▕ </><fg=magenta>[1m    }[0m</>
    <fg=gray> 11</><fg=gray>▕ </><fg=magenta>[1m}[0m</>
HTML
    );
});

it('renders the element with selected line', function () {
    $html = parse(<<<'HTML'
<div>
            <code line="7">
            &lt;?php

            /** @test */
            function sentryReport()
            {
                try {
                    throw new \Exception('Something went wrong');
                } catch (\Throwable $e) {
                    report($e);
                }
            }
            </code>
</div>
HTML
    );

    expect($html)->toBe(<<<'HTML'

    <fg=gray>  1</><fg=gray>▕ </>[1m<?php[0m
    <fg=gray>  2</><fg=gray>▕ </>
    <fg=gray>  3</><fg=gray>▕ </><fg=gray>[3m/** @test */[0m</>
    <fg=gray>  4</><fg=gray>▕ </><fg=magenta>[1mfunction [0m</>[1msentryReport[0m<fg=magenta>[1m()[0m</>
    <fg=gray>  5</><fg=gray>▕ </><fg=magenta>[1m{[0m</>
    <fg=gray>  6</><fg=gray>▕ </><fg=magenta>[1m    try {[0m</>
<fg=red>[1m  ➜ [0m</>[1m[3m  7[0m[0m<fg=gray>▕ </><fg=magenta>[1m        throw new \Exception([0m</><fg=gray>'Something went wrong'</><fg=magenta>[1m);[0m</>
    <fg=gray>  8</><fg=gray>▕ </><fg=magenta>[1m    } catch (\Throwable [0m</>[1m$e[0m<fg=magenta>[1m) {[0m</>
    <fg=gray>  9</><fg=gray>▕ </><fg=magenta>[1m        [0m</>[1mreport[0m<fg=magenta>[1m([0m</>[1m$e[0m<fg=magenta>[1m);[0m</>
    <fg=gray> 10</><fg=gray>▕ </><fg=magenta>[1m    }[0m</>
    <fg=gray> 11</><fg=gray>▕ </><fg=magenta>[1m}[0m</>
HTML
    );
});

it('renders the element with selected line and started line', function () {
    $html = parse(<<<'HTML'
    <div>
        <code line="20" start-line="14">
            &lt;?php

            /** @test */
            function sentryReport()
            {
                try {
                    throw new \Exception('Something went wrong');
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        </code>
    </div>
HTML
    );

    expect($html)->toBe(<<<'HTML'

    <fg=gray> 14</><fg=gray>▕ </><fg=blue>[1m    [0m</>[1m<?php[0m
    <fg=gray> 15</><fg=gray>▕ </>
    <fg=gray> 16</><fg=gray>▕ </>[1m    [0m<fg=gray>[3m/** @test */[0m</>
    <fg=gray> 17</><fg=gray>▕ </><fg=gray>[3m    [0m</><fg=magenta>[1mfunction [0m</>[1msentryReport[0m<fg=magenta>[1m()[0m</>
    <fg=gray> 18</><fg=gray>▕ </><fg=magenta>[1m    {[0m</>
    <fg=gray> 19</><fg=gray>▕ </><fg=magenta>[1m        try {[0m</>
<fg=red>[1m  ➜ [0m</>[1m[3m 20[0m[0m<fg=gray>▕ </><fg=magenta>[1m            throw new \Exception([0m</><fg=gray>'Something went wrong'</><fg=magenta>[1m);[0m</>
    <fg=gray> 21</><fg=gray>▕ </><fg=magenta>[1m        } catch (\Throwable [0m</>[1m$e[0m<fg=magenta>[1m) {[0m</>
    <fg=gray> 22</><fg=gray>▕ </><fg=magenta>[1m            [0m</>[1mreport[0m<fg=magenta>[1m([0m</>[1m$e[0m<fg=magenta>[1m);[0m</>
    <fg=gray> 23</><fg=gray>▕ </><fg=magenta>[1m        }[0m</>
    <fg=gray> 24</><fg=gray>▕ </><fg=magenta>[1m    }[0m</>
HTML
    );
});
