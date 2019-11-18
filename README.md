# Hierarchical model generator for Laravel

This package neatly keeps models into sub-directories without breaking the table naming scheme.

## Contents

- [Installation](#installation)
- [Changelog](#changelog)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)

## Installation

You can install the package via composer:

```bash
composer require sikhlana/laravel-modular
```

If your Laravel version is lower than 5.5 you need to install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Sikhlana\Modular\ModularServiceProvider::class,
],
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email xoxo@saifmahmud.name instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Saif Mahmud](https://github.com/sikhlana)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
