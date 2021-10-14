<p align="center">
    <img width="150" height="150" alt="Termwind logo" src="/art/logo.png"/>
</p>

<h1 align="center" style="border:none !important">
    <code>Termwind</code>
    <br>
    <br>
</h1>

<p align="center">
    <img src="/art/example.png" alt="TailCli example" height="300">
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

### Render table

```php
use function Termwind\{render};

render(<<<'HTML'
    <table style="box-double">
        <thead title="Books" class="bg-red text-color-white px-10">
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
                <th class="bg-blue text-color-red" align="right">9971-5-0210-0</th>
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
                <td rowspan="2" align="right">Dante Alighieri\nspans multiple rows</td>
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
HTML);
```

**Will render**

<p align="center">
    <img width="671" height="359" alt="Table" src="/art/table.png"/>
</p>

#### Table style
Table can have the `style` attribute to set specific table style. 

Available styles

```
- default
- borderless
- box
- box-double
```

See https://symfony.com/doc/current/components/console/helpers/table.html 


#### !!! Make sure that you have only one root element. !!!

**Wrong**
```html
<div>...</div>
<table>
       ...
</table>
```

**Correct**
```html
<div>
    <div>...</div>
    <table>
           ...
    </table>
</div>
```

#### Creating custom css classes

The `style()` function may be used to add own custom styles.

```php
use function Termwind\{style};

// Creates a new css class .btn with given classes
style('btn')->apply('p-4 bg-blue text-color-white');

// Applies .btn class to your tag
render('<div class="btn">Click me </div>');
```

## How To Contribute

Head over to [tailwindcss.com/docs](https://tailwindcss.com/docs), and choose a class that is not implemented in Termwind. As an example, let's assume you would like to add the `lowercase` Tailwind CSS class to Termwind:

1. Head over to [`src/Components/Element`](https://github.com/nunomaduro/termwind/blob/master/src/Components/Element.php#L250) and add a new method with the name `lowercase`:
```php
    /**
     * Makes the element's content lowercase.
     */
    final public function lowercase(): static
    {
        $content = mb_strtolower($this->content, 'UTF-8');

        return new static($this->output, $content, $this->properties);
    }
```

2. Next, add a new test in [`tests/classes.php`](https://github.com/nunomaduro/termwind/blob/master/tests/classes.php#L135) to see if the `lowercase` class works as expected:

```php
test('lowercase', function () {
    $html = parse('<div class="lowercase">tEXT</div>');

    expect($html)->toBe('<bg=default;options=>text</>');
});
```

3. Pull request the code, and that's it.

Termwind is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
