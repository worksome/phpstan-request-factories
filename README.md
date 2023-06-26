# PHPStan Request Factories

[![Latest Version on Packagist](https://img.shields.io/packagist/v/worksome/phpstan-request-factories.svg?style=flat-square)](https://packagist.org/packages/worksome/phpstan-request-factories)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/worksome/phpstan-request-factories/tests.yml?branch=main&style=flat-square&label=Tests)](https://github.com/worksome/phpstan-request-factories/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Static Analysis Action Status](https://img.shields.io/github/actions/workflow/status/worksome/phpstan-request-factories/static.yml?branch=main&style=flat-square&label=Static%20Analysis)](https://github.com/worksome/phpstan-request-factories/actions?query=workflow%3A"Static%20Analysis"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/worksome/phpstan-request-factories.svg?style=flat-square)](https://packagist.org/packages/worksome/phpstan-request-factories)

A PHPStan rule for enforcing that every request has a corresponding factory.

## Installation

You can install the package via composer:

```bash
composer require --dev worksome/phpstan-request-factories
```

If you have also installed [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) then everything will work out of the box.

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include `extension.neon` in your project's PHPStan config:

```
includes:
    - vendor/worksome/phpstan-request-factories/extension.neon
```
</details>

## Usage

### Choosing different namespaces

The request and factory namespaces are both configurable. They can be configured using the following parameters:

- `requestFactories.requestsNamespace` (default is `App\\Http\\Requests`)
- `requestFactories.factoriesNamespace` (default is `Tests\\RequestFactories`)

For example:

```yml
parameters:
  requestFactories:
    requestsNamespace: App\Http\Requests
    factoriesNamespace: Tests\RequestFactories
```

### Excluding request classes

If there are certain request classes that you want to exclude, you can exclude these using
the `excludedRequestClasses` parameter.

For example:

```yml
parameters:
  requestFactories:
    excludedRequestClasses:
        - App\Http\Requests\IgnorableRequest
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Owen Voke](https://github.com/owenvoke)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
