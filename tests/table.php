<?php

use function Termwind\parse;

it('can render table without thead, tbody, tfoot to a string', function () {
    $html = parse(<<<'HTML'
<table style="box">
    <tr>
        <th align="right">99921-58-10-7</th>
        <td>Divine Comedy</td>
        <td align="right">Dante Alighieri</td>
    </tr>
    <tr border="1">
        <th class="px-3">9971-5-0210-0</th>
        <td>

            A Tale of Two Cities

        </td>
        <td align="right">Charles Dickens</td>
    </tr>
    <tr>
        <th align="right">960-425-059-0</th>
        <td>The Lord of the Rings</td>
        <td align="right">J. R. R. Tolkien</td>
    </tr>
    <tr>
        <th align="right">80-902734-1-6</th>
        <td>And Then There Were None</td>
        <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
    </tr>
    <tr>
        <th align="right">978-052156781</th>
        <td>De Monarchia</td>
    </tr>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
├─────────────────────┼──────────────────────────┼─────────────────────┤
│       \e[1m99921-58-10-7\e[0m │ Divine Comedy            │     Dante Alighieri │
│    \e[1m9971-5-0210-0\e[0m    │ A Tale of Two Cities     │     Charles Dickens │
├─────────────────────┼──────────────────────────┼─────────────────────┤
│       \e[1m960-425-059-0\e[0m │ The Lord of the Rings    │    J. R. R. Tolkien │
\e[39;49m│       \e[1m80-902734-1-6\e[0m │ And Then There Were None │     Dante Alighieri │\e[39;49m
│       \e[1m978-052156781\e[0m │ De Monarchia             │ spans multiple rows │
└─────────────────────┴──────────────────────────┴─────────────────────┘
OUT
    );
});

it('can render table with thead to a string', function () {
    $html = parse(<<<'HTML'
<table>
    <thead title="Books" class="bg-red text-white px-10">
        <tr>
            <th align="right">ISBN</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
    </thead>
    <tr>
        <th align="right">99921-58-10-7</th>
        <td>Divine Comedy</td>
        <td align="right">Dante Alighieri</td>
    </tr>
    <tr border="1">
        <th class="bg-blue text-red" align="right">9971-5-0210-0</th>
        <td>A Tale of Two Cities</td>
        <td align="right">Charles Dickens</td>
    </tr>
    <tr>
        <th align="right">960-425-059-0</th>
        <td>The Lord of the Rings</td>
        <td align="right">J. R. R. Tolkien</td>
    </tr>
    <tr>
        <th align="right">80-902734-1-6</th>
        <td>And Then There Were None</td>
        <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
    </tr>
    <tr>
        <th align="right">978-052156781</th>
        <td>De Monarchia</td>
    </tr>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
+---------------+--\e[37;41m           Books           \e[39;49m-------------------+
|          \e[1mISBN\e[0m | \e[1mTitle\e[0m                    | \e[1mAuthor\e[0m              |
+---------------+--------------------------+---------------------+
| \e[1m99921-58-10-7\e[0m | Divine Comedy            |     Dante Alighieri |
| \e[31;44m\e[1m9971-5-0210-0\e[0m\e[39;49m | A Tale of Two Cities     |     Charles Dickens |
+---------------+--------------------------+---------------------+
| \e[1m960-425-059-0\e[0m | The Lord of the Rings    |    J. R. R. Tolkien |
\e[39;49m| \e[1m80-902734-1-6\e[0m | And Then There Were None |     Dante Alighieri |\e[39;49m
| \e[1m978-052156781\e[0m | De Monarchia             | spans multiple rows |
+---------------+--------------------------+---------------------+
OUT
    );
});

it('can render table with thead with two rows to a string', function () {
    $html = parse(<<<'HTML'
<table>
    <thead title="Books" class="bg-red text-white px-10">
        <tr border="1">
            <th align="right">Hello</th>
            <th>World</th>
            <th>Author</th>
        </tr>
        <tr>
            <th align="right">ISBN</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
    </thead>
    <tr>
        <th align="right">99921-58-10-7</th>
        <td>Divine Comedy</td>
        <td align="right">Dante Alighieri</td>
    </tr>
    <tr border="1">
        <th class="bg-blue text-red" align="right">9971-5-0210-0</th>
        <td>A Tale of Two Cities</td>
        <td align="right">Charles Dickens</td>
    </tr>
    <tr>
        <th align="right">960-425-059-0</th>
        <td>The Lord of the Rings</td>
        <td align="right">J. R. R. Tolkien</td>
    </tr>
    <tr>
        <th align="right">80-902734-1-6</th>
        <td>And Then There Were None</td>
        <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
    </tr>
    <tr>
        <th align="right">978-052156781</th>
        <td>De Monarchia</td>
    </tr>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
+---------------+--\e[37;41m           Books           \e[39;49m-------------------+
|          \e[1mISBN\e[0m | \e[1mTitle\e[0m                    | \e[1mAuthor\e[0m              |
+---------------+--------------------------+---------------------+
| \e[1m99921-58-10-7\e[0m | Divine Comedy            |     Dante Alighieri |
| \e[31;44m\e[1m9971-5-0210-0\e[0m\e[39;49m | A Tale of Two Cities     |     Charles Dickens |
+---------------+--------------------------+---------------------+
| \e[1m960-425-059-0\e[0m | The Lord of the Rings    |    J. R. R. Tolkien |
\e[39;49m| \e[1m80-902734-1-6\e[0m | And Then There Were None |     Dante Alighieri |\e[39;49m
| \e[1m978-052156781\e[0m | De Monarchia             | spans multiple rows |
+---------------+--------------------------+---------------------+
OUT
    );
});

it('can render table with tfoot to a string', function () {
    $html = parse(<<<'HTML'
<table>
    <tr>
        <th align="right">99921-58-10-7</th>
        <td>Divine Comedy</td>
        <td align="right">Dante Alighieri</td>
    </tr>
    <tr border="1">
        <th class="bg-blue text-red" align="right">9971-5-0210-0</th>
        <td>A Tale of Two Cities</td>
        <td align="right">Charles Dickens</td>
    </tr>
    <tr>
        <th align="right">960-425-059-0</th>
        <td>The Lord of the Rings</td>
        <td align="right">J. R. R. Tolkien</td>
    </tr>
    <tr>
        <th align="right">80-902734-1-6</th>
        <td>And Then There Were None</td>
        <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
    </tr>
    <tr>
        <th align="right">978-052156781</th>
        <td>De Monarchia</td>
    </tr>
    <tfoot title="Page 1/2" class="mx-5 bg-blue">
        <tr>
            <th colspan="3">This value spans 3 columns.</th>
        </tr>
    </tfoot>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
+---------------+--------------------------+---------------------+
| \e[1m99921-58-10-7\e[0m | Divine Comedy            |     Dante Alighieri |
| \e[31;44m\e[1m9971-5-0210-0\e[0m\e[39;49m | A Tale of Two Cities     |     Charles Dickens |
+---------------+--------------------------+---------------------+
| \e[1m960-425-059-0\e[0m | The Lord of the Rings    |    J. R. R. Tolkien |
\e[39;49m| \e[1m80-902734-1-6\e[0m | And Then There Were None |     Dante Alighieri |\e[39;49m
| \e[1m978-052156781\e[0m | De Monarchia             | spans multiple rows |
+---------------+--------------------------+---------------------+
| \e[1mThis value spans 3 columns.\e[0m                                    |
+---------------+------     \e[44m Page 1/2 \e[49m     +---------------------+
OUT
    );
});

it('can render table with tbody to a string', function () {
    $html = parse(<<<'HTML'
<table>
    <tbody>
        <tr>
            <th align="right">99921-58-10-7</th>
            <td>Divine Comedy</td>
            <td align="right">Dante Alighieri</td>
        </tr>
        <tr border="1">
            <th class="bg-blue text-red" align="right">9971-5-0210-0</th>
            <td>A Tale of Two Cities</td>
            <td align="right">Charles Dickens</td>
        </tr>
        <tr>
            <th align="right">960-425-059-0</th>
            <td>The Lord of the Rings</td>
            <td align="right">J. R. R. Tolkien</td>
        </tr>
        <tr>
            <th align="right">80-902734-1-6</th>
            <td>And Then There Were None</td>
            <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
        </tr>
        <tr>
            <th align="right">978-052156781</th>
            <td>De Monarchia</td>
        </tr>
    </tbody>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
+---------------+--------------------------+---------------------+
| \e[1m99921-58-10-7\e[0m | Divine Comedy            |     Dante Alighieri |
| \e[31;44m\e[1m9971-5-0210-0\e[0m\e[39;49m | A Tale of Two Cities     |     Charles Dickens |
+---------------+--------------------------+---------------------+
| \e[1m960-425-059-0\e[0m | The Lord of the Rings    |    J. R. R. Tolkien |
\e[39;49m| \e[1m80-902734-1-6\e[0m | And Then There Were None |     Dante Alighieri |\e[39;49m
| \e[1m978-052156781\e[0m | De Monarchia             | spans multiple rows |
+---------------+--------------------------+---------------------+
OUT
    );
});

it('can render table with thead, tbody, tfoot to a string', function () {
    $html = parse(<<<'HTML'
<table style="box-double">
    <thead title="Books" class="bg-red text-white px-10">
        <tr>
            <th align="right">ISBN</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th align="right">99921-58-10-7</th>
            <td>Divine Comedy</td>
            <td align="right">Dante Alighieri</td>
        </tr>
        <tr border="1">
            <th class="bg-blue text-red" align="right">9971-5-0210-0</th>
            <td>A Tale of Two Cities</td>
            <td align="right">Charles Dickens</td>
        </tr>
        <tr>
            <th align="right">960-425-059-0</th>
            <td>The Lord of the Rings</td>
            <td align="right">J. R. R. Tolkien</td>
        </tr>
        <tr>
            <th align="right">80-902734-1-6</th>
            <td>And Then There Were None</td>
            <td rowspan="2" align="right">Dante Alighieri<br>spans multiple rows</td>
        </tr>
        <tr>
            <th align="right">978-052156781</th>
            <td>De Monarchia</td>
        </tr>
    </tbody>
    <tfoot title="Page 1/2" class="mx-5 bg-blue">
        <tr>
            <th colspan="3">This value spans 3 columns.</th>
        </tr>
    </tfoot>
</table>
HTML
    );

    expect($html)->toBe(<<<OUT
╔═══════════════╤══\e[37;41m           Books           \e[39;49m═══════════════════╗
║          \e[1mISBN\e[0m │ \e[1mTitle\e[0m                    │ \e[1mAuthor\e[0m              ║
╠═══════════════╪══════════════════════════╪═════════════════════╣
║ \e[1m99921-58-10-7\e[0m │ Divine Comedy            │     Dante Alighieri ║
║ \e[31;44m\e[1m9971-5-0210-0\e[0m\e[39;49m │ A Tale of Two Cities     │     Charles Dickens ║
╟───────────────┼──────────────────────────┼─────────────────────╢
║ \e[1m960-425-059-0\e[0m │ The Lord of the Rings    │    J. R. R. Tolkien ║
\e[39;49m║ \e[1m80-902734-1-6\e[0m │ And Then There Were None │     Dante Alighieri ║\e[39;49m
║ \e[1m978-052156781\e[0m │ De Monarchia             │ spans multiple rows ║
╟───────────────┼──────────────────────────┼─────────────────────╢
║ \e[1mThis value spans 3 columns.\e[0m                                    ║
╚═══════════════╧══════     \e[44m Page 1/2 \e[49m     ╧═════════════════════╝
OUT
    );
});

it('can render an <a> inside of a table', function () {
    $html = parse(<<<'HTML'
        <table>
            <tr>
                <td>
                    <a href="url">Test</a>
                </td>
            </tr>
        </table>
    HTML);

    expect($html)->toBe(<<<OUT
    +------+
    | \e]8;;url\e\Test\e]8;;\e\ |
    +------+
    OUT);
});
