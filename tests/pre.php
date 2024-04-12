<?php

use function Termwind\parse;

it('renders the element', function () {
    $content = '    <h1>Introduction</h1>

    <div>The body of your message.</div>

    Thanks,
    Laravel

    © 2021 Laravel. All rights reserved.';

    $html = parse("<pre>$content</pre>");

    expect($html)->toBe('
    <h1>Introduction</h1>'.str_repeat(' ', 19).'
'.str_repeat(' ', 44).'
    <div>The body of your message.</div>'.str_repeat(' ', 4).'
'.str_repeat(' ', 44).'
    Thanks,'.str_repeat(' ', 33).'
    Laravel'.str_repeat(' ', 33).'
'.str_repeat(' ', 44).'
    © 2021 Laravel. All rights reserved.'.str_repeat(' ', 3)
    );
});

it('renders the element with styles', function () {
    $html = parse('<pre class="bg-blue text-red font-bold italic">
    <h1>Introduction</h1>

    <div>The body of your message.</div>

    Thanks,
    Laravel

    © 2021 Laravel. All rights reserved.
</pre>');

    expect($html)->toBe("
<bg=blue;fg=red;options=bold>\e[3m    <h1>Introduction</h1>                   \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m                                            \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m    <div>The body of your message.</div>    \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m                                            \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m    Thanks,                                 \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m    Laravel                                 \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m                                            \e[0m</>
<bg=blue;fg=red;options=bold>\e[3m    © 2021 Laravel. All rights reserved.   \e[0m</>");
});
