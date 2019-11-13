# Mailcheck for PHP

Validate and suggest emails for your email inputs

## Disclaimer

This library uses by default a public data source to suggest various know email 
providers.

As this list is pretty much a work in progress you may be missing some domains, 
so please feel free to open an issue or a pull request to improve it.

## Installation

`composer require devnix/mailcheck`

## Usage

You just need to initialize an instance to get a shiny suggestion service!

```php
use Devnix\Mailcheck\Mailcheck;

$mailcheck = new Mailcheck();
```

Then you can ask for an array of suggestions, ordered by Levenshtein distance...

```php
$mailcheck->suggest('example@gmil.com');
```

```
array:5 [
  0 => "example@gmail.com"
  1 => "example@gmx.com"
  2 => "example@mail.com"
  3 => "example@email.com"
  4 => "example@ymail.com"
]
```

...or just the first coincidence

```php
$mailcheck->suggestOne('example@gmil.com');
```

```
"example@gmail.com"
```

## Contributing

You can help by reporting bugs, submitting pull requests, providing feedback 
about your needs or bad suggestions. 

You can execute all the tests by rugging `composer test`. We use tools like 
[PHPStan](https://github.com/phpstan/phpstan), 
[PHPUnit](https://github.com/sebastianbergmann/phpunit), and 
[PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer). We like to follow 
the [Symfony Coding Standars](https://symfony.com/doc/current/contributing/code/standards.html).