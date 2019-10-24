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
and settings (available in the app; changeable by users during runtime):

| Configuration Value                                                                              | Setting                                                            |
| ------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------ |
| Set on the command line in a YAML/JSON/INI file or environment variable during application setup | Set in the application's API or web interface                      |
| Managed by system administrator or developer                                                     | Managed by application user                                        |
| Not likely to ever change                                                                        | Mutable and able to change during runtime                          |
| Should be set before application can be executed                                                 | Not necessary during app bootstrap                                 |

## Concepts

A **Setting Definition** is simply a PHP class that implements the 
`SettingDefinition` interface.  A setting definition has the following attributes:

* A name (e.g. a machine name/slug)
* A display name
* Internal notes
* An optional default value
* Optional validation/transform logic for processing incoming values

Setting definitions are added to the `SettingDefinitionRegistry`.

A **Setting Provider** is a service class that loads setting values from a source.  Sources can be configuration files,
databases, or really anything.  See [usage](#usage) section below for a list of bundled providers.

Multiple providers can be chained together so that setting values are loaded in a cascading way.  Several providers have been bundled (see below), but you can feel free to add
your own by extending the `SettingProvider` interface.  Providers have similar attributes to definitions:

* A name (e.g. a machine name/slug)
* A display name

A **Setting Value** is an object that stores the value of the setting, along with a few additional values:

* The setting name
* The provider name that this setting came was defined by
* Whether or not the setting is mutable or not (see further explanation below)

## Install

Via Composer

``` bash
$ composer require caseyamcl/settings-manager
```

## Usage

### Basic Usage

The basic usage of this library consists of two steps:

1. Defining setting definitions
2. Loading setting values from providers


#### Defining setting definitions

The recommended way to create settings is for each setting definition to be a class.  While this isn't strictly necessary
(you can create a class that implements `AbstractSettingDefinition`), it does keep things clean and simple.

```php
<?php

use SettingsManager\Model\AbstractSettingDefinition;
use SettingsManager\Exception\InvalidSettingValueException;

/**
 * 
 */
class MySetting extends AbstractSettingDefinition
{
    // This is the machine name, and it is recommended that you stick to machine-friendly names (alpha-dash, underscore)
    public const NAME = 'my_setting';
    
    // This is the "human friendly" name for the setting
    public const DISPLAY_NAME = 'My Setting';
    
    // Internal notes for administrators
    public const NOTES = '';
    
    // Set an optional default (may need to override the getDefault() method if complex logic is required)
    public const DEFAULT = null;
    
    // Indicate whether this value is sensitive or not.  By default, this is set to TRUE
    // This is relevant if the application wants to expose some setting values to all users, while hiding other ones
    public const SENSITIVE = true;
    
    /**
     * If there is any validation for this setting, you can override the processValue() method
     * 
     * Throw an InvalidSettingValueException in the case of an invalid value
     */
    public function processValue($value)
    {
        if (! is_string($value)) {
            $errors[] = "value must be a string";
        }
        if ($value !== 'test') {
            $errors[] = "value must be equal to 'test'";
        }
    
        if (! empty($errors)) {
            throw new InvalidSettingValueException($errors);
        }
        
        return $value;
    }
}

```

#### Loading setting values from providers

TODO: This.

TODO: bundled providers

TODO: creating your own provider implementation

TODO: handling exceptions (all implement the `SettingException` interface)

TODO: Considerations for loading settings during runtime.

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
