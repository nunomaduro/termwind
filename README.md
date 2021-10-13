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

## Installation & Usage

> **Requires [PHP 8.0+](https://php.net/releases/)**

Require Termwind using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/termwind
```

### Get Started

```php
use function Termwind\{render};

// single line html
render('<div class="p-2 text-color-white bg-blue">Hello World</div>');

// multi-line html
render(<<<'HTML'
    <div class="p-2 text-color-white bg-blue">
        <a class="ml-2">foo</a>
        <a class="ml-2" href="https://nunomaduro.com">nunomaduro.com</a>
    </div>
HTML);

// Symfony / Laravel console commands
use function Termwind\{render};

class UsersAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:all';

    /**
     * Execute the console command.
     *
     * @return int
     */
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

#### Render table

```php
render(<<<'HTML'
    <table style="box">
        <thead>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>4</td>
                <td>9</td>
                <td class="ml-5">6</td>
            </tr>
            <tr>
                <td class="bg-blue text-color-red" align="center">7</td>
                <td colspan="2" align="center">4</td>
            </tr>
            <tr>
                <td class="mx-10">12</td>
                <td>12</td>
                <td align="center">13</td>
            </tr>
        </tbody>
    </table>
HTML);
```

**Will render**

<p align="center">
    <img width="407" height="205" alt="Table" src="/art/table.png"/>
</p>

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
use function Termwind\{style, span};

// Creates a new css class .btn with given classes
style('btn')->apply('p-4 bg-blue text-color-white');

// Applies .btn class to your tag
render('<div class="btn">Click me </div>');
```

Termwind is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
