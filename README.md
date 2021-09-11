<!-- statamic:hide -->
# Statamic Blade Components

[![Statami v3](https://img.shields.io/badge/Statamic-3.0+-FF269E)](https://statamic.com/addons/octoper/blade-components)
[![Packagist](https://img.shields.io/packagist/v/octoper/statamic-blade-components)](https://packagist.org/packages/octoper/statamic-blade-components)
[![Tests](https://github.com/octoper/statamic-blade-components/actions/workflows/tests.yaml/badge.svg)](https://github.com/octoper/statamic-blade-components/actions/workflows/tests.yaml)
[![StyleCI](https://github.styleci.io/repos/290389800/shield?branch=main)](https://github.styleci.io/repos/290389800?branch=main)

A [Laravel Blade Components](https://laravel.com/docs/8.x/blade#components) integration for Statamics Antlers template engine.
<!-- /statamic:hide -->

## Installation
You can install the package via composer:
```bash
composer require octoper/statamic-blade-components
```

## General documentation
[Laravel Blade Components](https://laravel.com/docs/8.x/blade#components)

## How to be used with the Antlers template engine
```html
{{ component:hello }}
```

### Passing Initial Parameters
You can pass data into a component by passing additional parameters

```html
{{ component:avatar username="johndoe" }}
```

### Passing Slots
You can pass additional content to your component via "slots" too.

```html
{{ component:label for="email" }}
	Email
{{ /component:label }}
```

or even named slots

```html
{{ component:label for="email" }}
	{{ component:slot name="title" }}
		Email
	{{ /component:slot}}
{{ /component:label }}
```

## Testing

``` bash
composer test
```

## Security

If you discover any security related issues, please email me@octoper.me instead of using the issue tracker.

## Credits

- [Vaggelis Yfantis](https://github.com/octoper)
- [All Contributors](../../contributors)

<!-- statamic:hide -->
## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
<!-- /statamic:hide -->
