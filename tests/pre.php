<?php

it('renders the element', function () {
    $content = "    <h1>Introduction</h1>

    <div>The body of your message.</div>

    Thanks,
    Laravel

    © 2021 Laravel. All rights reserved.";

    $html = parse("<pre>$content</pre>");

    expect($html)->toBe(
        "\n".implode("\n", array_map(
            fn(string $line) => str_pad($line, 44),
            explode("\n", $content)
        ))
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
<bg=blue;fg=red>\e[3m\e[1m    <h1>Introduction</h1>                   \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m                                            \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m    <div>The body of your message.</div>    \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m                                            \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m    Thanks,                                 \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m    Laravel                                 \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m                                            \e[0m\e[0m</>
<bg=blue;fg=red>\e[3m\e[1m    © 2021 Laravel. All rights reserved.   \e[0m\e[0m</>");
});
