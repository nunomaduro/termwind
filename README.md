<p align="center">
    <img src="https://raw.githubusercontent.com/nunomaduro/tailcli/master/art/example.png" alt="TailCli example" height="300">
    <p align="center">
        <a href="https://github.com/nunomaduro/tailcli/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/workflow/status/nunomaduro/tailcli/Tests/master"></a>
        <a href="https://packagist.org/packages/nunomaduro/tailcli"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/nunomaduro/tailcli"></a>
        <a href="https://packagist.org/packages/nunomaduro/tailcli"><img alt="Latest Version" src="https://img.shields.io/packagist/v/nunomaduro/tailcli"></a>
        <a href="https://packagist.org/packages/nunomaduro/tailcli"><img alt="License" src="https://img.shields.io/packagist/l/nunomaduro/tailcli"></a>
    </p>
</p>

------
**TailCli** allows you to building unique and beautiful command-line applications, using the **[Tailwind CSS](https://tailwindcss.com/)** API. In short, it's like Tailwind CSS, but for the console.

## Installation & Usage

> **Requires [PHP 8.0+](https://php.net/releases/)**

Require TailCli using [Composer](https://getcomposer.org):

```bash
composer require nunomaduro/tailcli --dev
```

### Get Started

```php
use function TailCli\{line, render};

// Render one line...
line('foo')->pl2()->fontBold()->textColor('red')->render();

// Render multiple lines...
render([
    line(),
    line()->ml(20)->bg('red'),
    line(),
]);
```

TailCli is an open-sourced software licensed under the **[MIT license](https://opensource.org/licenses/MIT)**.
