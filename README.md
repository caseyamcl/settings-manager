# Settings Manager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a framework-agnostic library that provides a structure for managing and storing user-changeable settings.
Settings can be stored in a configuration file, database, external API or anywhere else! 

It provides the following common utilities:

* Class-based definition for settings
* A registry for settings
* Ability to define multiple providers for settings
* Ability to validate and prepare/transform setting values 

## What is a setting?

This library is useful for projects that make a clear distinction between configuration values (set by admins)
and settings (available in the app; changeable by users):

| Configuration Value                                                                              | Setting                                                            |
| ------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------ |
| Set on the command line in a YAML/JSON/INI file or environment variable during application setup | Set in the application's API or web interface                      |
| Managed by system administrator or developer                                                     | Managed by application user                                        |
| Not likely to ever change                                                                        | Mutable and able to change during runtime                          |
| Should be set before application can be executed                                                 | Not necessary during app bootstrap                                 |

## Concepts

A **Setting** is simply a PHP class that implements the `SettingInterface` interface.  A setting has the
following attributes:

* A name (e.g. a machine name/slug)
* A display name
* Internal notes
* An optional default value
* Optional validation/transform logic for processing incoming values

A **Setting Provider** is a service class that loads setting values.  Multiple providers can be chained together so that
setting values are loaded in a cascading way.

## Install

Via Composer

``` bash
$ composer require caseyamcl/settings-manager
```


## Usage

### TODO: Using with Symfony

### TODO: Using with Laravel

### TODO: Using with PHP-DI


## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email caseyamcl@gmail.com instead of using the issue tracker.

## Credits

- [Casey McLaughlin][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/caseyamcl/settings-manager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/caseyamcl/settings-manager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/caseyamcl/settings-manager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/caseyamcl/settings-manager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/caseyamcl/settings-manager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/caseyamcl/settings-manager
[link-travis]: https://travis-ci.org/caseyamcl/settings-manager
[link-scrutinizer]: https://scrutinizer-ci.com/g/caseyamcl/settings-manager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/caseyamcl/settings-manager
[link-downloads]: https://packagist.org/packages/caseyamcl/settings-manager
[link-author]: https://github.com/caseyamcl
[link-contributors]: ../../contributors
