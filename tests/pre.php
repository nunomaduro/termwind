<?php

it('renders the element', function () {
    $html = parse("<pre>
    <h1>Introduction</h1>

    <div>The body of your message.</div>

    Thanks,
    Laravel

    © 2021 Laravel. All rights reserved.
</pre>");

    expect($html)->toBe("
    <h1>Introduction</h1>

    <div>The body of your message.</div>

    Thanks,
    Laravel

    © 2021 Laravel. All rights reserved.
");
});
