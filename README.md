<p align="center">
    <img width="150" height="150" alt="Termwind logo" src="/art/logo.png"/>
</p>

<h1 align="center" style="border:none !important">
    <code>Termwind</code>
    <br>
    <br>
</h1>

<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/tailcli/master/art/example.png" alt="TailCli example" height="300">
    <p align="center">
        <a href="https://github.com/nunomaduro/termwind/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/workflow/status/nunomaduro/termwind/Tests/master"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/termwind"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/termwind"></a>
        <a href="https://packagist.org/packages/nunomaduro/termwind"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/termwind"></a>
    </p>
</p>

------
**Termwind** allows you to build unique and beautiful PHP command-line applications, using the **[Tailwind CSS](https://tailwindcss.com/)** API. In short, it's like Tailwind CSS, but for the PHP command-line applications.

## Installation

> **Requires [PHP 8.0+](https://php.net/releases/)**

Require Termwind using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/termwind
```

## Usage

```php
use function Termwind\{render};

// single line html...
render('<div class="p-1 bg-green-300">Termwind</div>');

// multi-line html...
render(<<<'HTML'
    <div>
        <div class="p-1 bg-green-300">Termwind</div>
        <em class="ml-1">
          Give your CLI apps a unique look
        </em>
    </div>
HTML);

// Laravel or Symfony console commands...
class UsersCommand extends Command
{
    public function handle()
    {
        render(
            view('users.index', [
                'users' => User::all()
            ])
        );
    }
}
```

### `style()`

The `style()` function may be used to add own custom syles and also update colors.

```php
use function Termwind\{style};

style('green-300')->color('#bada55');
style('btn')->apply('p-4 bg-green-300 text-white');

render('<div class="btn">Click me</div>');
```

### `ask()`

The `ask()` function may be used prompt the user with a question.

```php
use function Termwind\{ask};

$answer = ask(<<<HTML
    <span class="mt-1 ml-2 mr-1 bg-green px-1 text-black">
        What is your name?
    </span>
HTML);
```

The `return` provided from the ask method will be the answer provided from the user.

### `terminal()`

The `terminal()` function returns an instance of the [Terminal](https://github.com/nunomaduro/termwind/blob/master/src/Terminal.php) class, with the following methods:

* `->width()`: Returns the full width of the terminal.
* `->height()`: Returns the full height of the terminal.
* `->clear()`: It clears the terminal screen.

## Classes Supported

All the classes supported use exactly the same logic that is available on [tailwindcss.com/docs](https://tailwindcss.com/docs).

* **[Background Color](https://tailwindcss.com/docs/background-color):** `bg-{color}-{variant}`
* **[Text Color](https://tailwindcss.com/docs/text-color):** `text-{color}-{variant}`
* **[Font Weight](https://tailwindcss.com/docs/font-weight#class-reference):** `font-bold`, `font-normal`
* **[Font Style](https://tailwindcss.com/docs/font-style#italics):** `italic`
* **[Text Decoration](https://tailwindcss.com/docs/text-decoration):** `underline`, `line-through`
* **[Text Transform](https://tailwindcss.com/docs/text-transform):** `uppercase`, `lowercase`, `capitalize`, `snakecase`
* **[Text Overflow](https://tailwindcss.com/docs/text-overflow):** `truncate`
* **[Text Alignment](https://tailwindcss.com/docs/text-align):** `text-left`, `text-center`, `text-right`
* **[Margin](https://tailwindcss.com/docs/margin):** `m-{margin}`, `ml-{leftMargin}`, `mr-{rightMargin}`, `mt-{topMargin}`, `mb-{bottomMargin}`, `mx-{horizontalMargin}`, `my-{verticalMargin}`.
* **[Padding](https://tailwindcss.com/docs/padding):** `p-{padding}`, `pl-{leftPadding}`, `pr-{rightPadding}`, `pt-{topPadding}`, `pb-{bottomPadding}`, `px-{horizontalPadding}`.
* **[Width](https://tailwindcss.com/docs/width):** `w-{width}`, `w-full`
* **[Max Width](https://tailwindcss.com/docs/max-width):** `max-w-{width}`
* **[Visibility](https://tailwindcss.com/docs/visibility):** `invisible`
* **[Display](https://tailwindcss.com/docs/display):** `block`
* **[List Style](https://tailwindcss.com/docs/list-style-type):** `list-disc`, `list-decimal`, `list-square`, `list-none`

## HTML Elements Supported

All the elements have the capability to use the `class` attribute.

### `<div>`

The `<div>` element can be used as a block type element.

**Default Styles**: `block`

```php
render(<<<'HTML'
    <div>This is a div element.</div>
HTML);
```

### `<p>`

The `<p>` element can be used as a paragraph.

**Default Styles**: `block`

```php
render(<<<'HTML'
    <p>This is a paragraph.</p>
HTML);
```

### `<span>`

The `<span>` element can be used as a inline text container.

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <span class="text-green-300">Termwind</span>.
    </p>
HTML);
```

### `<a>`

The `<a>` element can be used as an hyperlink. It allows to use the `href` attribute to open the link when clicked.

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with Termwind. <a href="/">Click here to open</a>
    </p>
HTML);
```

### `<b>` and `<strong>`

The `<b>`and `<strong>` elements can be used to mark the text as **bold**.

**Default Styles**: `font-bold`

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <b>Termwind</b>.
    </p>
HTML);
```

### `<i>` and `<em>`

The `<i>` and `<em>` elements can be used to mark the text as *italic*.

**Default Styles**: `italic`

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <i>Termwind</i>.
    </p>
HTML);
```

### `<s>`

The `<s>`  element can be used to add a ~~line through~~ the text.

**Default Styles**: `line-through`

```php
render(<<<'HTML'
    <p>
        This is a CLI app built with <s>Termwind</s>.
    </p>
HTML);
```

### `<br>`

The `<br>` element can be used to do a line break.

```php
render(<<<'HTML'
    <p>
        This is a CLI <br>
        app built with Termwind.
    </p>
HTML);
```

### `<ul>`

The `<ul>` element can be used for an unordered list. It can only accept `<li>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`, `list-disc`

```php
render(<<<'HTML'
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
    </ul>
HTML);
```

### `<ol>`

The `<ol>` element can be used for an ordered list. It can only accept `<li>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`, `list-decimal`

```php
render(<<<'HTML'
    <ol>
        <li>Item 1</li>
        <li>Item 2</li>
    </ol>
HTML);
```

### `<li>`

The `<li>` element can be used as a list item. It should only be used as a child of `<ul>` and `<ol>` elements.

**Default Styles**: `block`, `list-decimal`

```php
render(<<<'HTML'
    <ul>
        <li>Item 1</li>
    </ul>
HTML);
```

### `<dl>`

The `<dl>` element can be used for an description list. It can only accept `<dt>` or `<dd>` elements as childs, if there is another element provided it will throw an `InvalidChild` exception. 

**Default Styles**: `block`

```php
render(<<<'HTML'
    <dl>
        <dt>🍃 Termwind</dt>
        <dd>Give your CLI apps a unique look</dd>
    </dl>
HTML);
```

### `<dt>`

The `<dt>` element can be used as a description title. It should only be used as a child of `<dl>` elements.

**Default Styles**: `block`, `font-bold`

```php
render(<<<'HTML'
    <dl>
        <dt>🍃 Termwind</dt>
    </dl>
HTML);
```

### `<dd>`

The `<dd>` element can be used as a description title. It should only be used as a child of `<dl>` elements.

**Default Styles**: `block`, `ml-4`

```php
render(<<<'HTML'
    <dl>
        <dd>Give your CLI apps a unique look</dd>
    </dl>
HTML);
```

### `<hr>`

The `<hr>` element can be used as an horizontal line.

```php
render(<<<'HTML'
    <div>
        <div>🍃 Termwind</div>
        <hr>
        <p>Give your CLI apps a unique look</p>
    </div>
HTML);
```

### `<table>`

The `<table>` element can have columns and rows.

```php
render(<<<'HTML'
    <table>
        <thead>
            <tr>
                <th>Task</th>
                <th>Status</th>
            </tr>
        </thead>
        <tr>
            <th>Termwind</th>
            <td>✓ Done</td>
        </tr>
    </table>
HTML);
```

### `<pre>`

The `<pre>` element can be used as preformatted text.

```php
render(<<<'HTML'
    <pre>
        Text in a pre element
        it preserves
        both      spaces and
        line breaks
    </pre>
HTML);
```

### `<code>`

The `<code>` element can be used as code highligher. It accepts `line` and `start-line` attributes.

```php
render(<<<'HTML'
    <code line="22" start-line="20">
        try {
            throw new \Exception('Something went wrong');
        } catch (\Throwable $e) {
            report($e);
        }
    </code>
HTML);
```

---

Termwind is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
