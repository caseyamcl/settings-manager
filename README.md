# Settings Manager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is a framework-agnostic library that provides an abstraction for managing and storing user-changeable settings.
Settings can be stored in a configuration file, database, external API or anywhere else.  The defining characteristic
of this library is designed around the assumption that settings will be modified during runtime, which makes it particularly
useful for increasingly popular architectures such as [Swoole](https://www.swoole.co.uk/), [React](https://reactphp.org/), etc.

It provides the following features:

* Class-based setting definitions
* Ability to define multiple providers for settings and load them in a cascading manner
* Ability to validate and prepare/transform setting values
* PSR-4 and PSR-12 compliance; 100% unit test coverage 

## What is a setting?

This library is useful for projects that make a clear distinction between configuration values (set by administrators)
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
* Whether or not this value is sensitive (e.g. should be treated securely)

Setting definitions are added to an instance of the `SettingDefinitionRegistry`.

A **Setting Provider** is a service class that loads setting values from a source.  Sources can be configuration files,
databases, or really anything.  See the [usage](#usage) section below for a list of bundled providers.

Multiple providers can be chained together so that setting values are loaded in a cascading way.  Several providers have been bundled (see below), but you can feel free to add
your own by implementing the `SettingProvider` interface.  Providers have similar attributes to definitions:

* A name (e.g. a machine name/slug)
* A display name

A **Setting Value** is an object that stores the value of the setting, along with a few additional bits of information:

* The setting name
* The provider name that this setting came was defined by
* Mutability - whether this setting can be overridden after this provider (e.g. an administrator may want to 
  lock a setting in-place in a configuration file and not allow a downstream provider to change it)

## Install

Via Composer

``` bash
$ composer require caseyamcl/settings-manager
```

## Usage

### Basic Usage

Basic usage of this library consists of two steps:

1. Defining setting definitions
2. Loading setting values from providers

#### Defining setting definitions

The recommended way to create settings is for each setting definition to be its own class.  While this isn't strictly necessary
(you can create any class that implements `SettingDefinition`), it does keep things clean and simple.

For convenience, this library includes the `AbstractSettingDefinition` class, which includes constants
for common attributes.  See the following example: 

```php

use SettingsManager\Model\AbstractSettingDefinition;
use SettingsManager\Exception\InvalidSettingValueException;
use SettingsManager\Registry\SettingDefinitionRegistry;

// 1. Create setting definition:

/**
 * Settings must implement the SettingDefinition interface.
 * 
 * For convenience, an AbstractSettingDefinition class is bundled with the library.  
 */
class MySetting extends AbstractSettingDefinition
{
    // Required; This is the machine name, and it is recommended that you stick to machine-friendly names (alpha-dash, underscore)
    public const NAME = 'my_setting';
    
    // Required; This is the "human friendly" name for the setting
    public const DISPLAY_NAME = 'My Setting';
    
    // Internal notes (optional)
    public const NOTES = "These are notes that are either available to all users or just admins (implementor's choice)";
    
    // Set an optional default (may need to override the getDefault() method if complex logic is required)
    public const DEFAULT = null;
    
    // Indicate whether this value is sensitive or not.  By default, this is set to TRUE
    // This is relevant if the application wants to expose some setting values to all users, while hiding other ones
    public const SENSITIVE = true;
    
    /**
     * If there is any validation for this setting, you can override the processValue() method
     * 
     * Throw an InvalidSettingValueException in the case of an invalid value
     * 
     * @param string $value
     * @return string
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
            // InvalidSettingValueException allows for multiple error messages
            throw new InvalidSettingValueException($errors);
        }
        
        return $value;
    }
}

// 2. Add it to the registry:

$registry = new SettingDefinitionRegistry();
$registry->add(new MySetting());
// etc.  add more values...
```

#### Loading setting values from providers

Setting values are loaded from setting providers.  There are a few bundled providers 
included in this library, and you can create your own by implementing the `SettingsManager\Contract\SettingProvider` interface.

In this example, we use the `CascadingSettingProvider` to combine the functionality of
the `DefaultValuesProvider` and the `ArrayValuesProvider`:

```php
use SettingsManager\Provider\CascadingSettingProvider;
use SettingsManager\Provider\DefaultValuesProvider;
use SettingsManager\Provider\ArrayValuesProvider;
use SettingsManager\Registry\SettingDefinitionRegistry;

// Setup a registry and add settings to it...
$registry = new SettingDefinitionRegistry();
$registry->add(new MySetting());

// An array of setting values
$settingValues = [
    'my_setting' => 'test'
];

// Setup the provider
$provider = new CascadingSettingProvider([
    new DefaultValuesProvider($registry), // loads default values
    new ArrayValuesProvider($settingValues, $registry), // loads values from an array
]);

// Get values from the provider..
$provider->findValue('my_setting'); // returns 'test'
$provider->getValue('my_setting'); // returns 'test' (would throw an exception if value isn't defined)

// If you want to get the `SettingValue` instance (with metadata), use
// `findValueInstance` or `getValueInstance`
$provider->getValueInstance('my_setting')->getValue();
$provider->findValueInstance('my_setting')->getValue();

// `getValue` throws an exception if the requested setting isn't defined 
$provider->getValue('non_existent_value'); // Throws UndefinedSettingException

// `findValue()` returns NULL if the requested setting isn't defined
$provider->findValue('non_existent_value'); // returns NULL

```

### Bundled providers

Basic setting providers are bundled with this library in the `SettingsManager\Provider` namespace:

| Provider                    | What it does                                           |
| --------------------------- | ------------------------------------------------------ |
| `ArrayValuesProvider`       | Loads values from an array                             |
| `DefaultValuesProvider`     | Loads default values                                   |
| `CascadingSettingProvider`  | Loads from multiple providers                          |
| `SettingRepositoryProvider` | Loads values from a database or repository (see below) |

### Setting mutability

Sometimes you want settings to be "locked" by a certain provider.  For example, if you want a setting to be unchangeable after a
certain provider has loaded it (say, a configuration file), you can use the following syntax:

```php

use SettingsManager\Provider\ArrayValuesProvider;
use SettingsManager\Provider\DefaultValuesProvider;
use SettingsManager\Provider\SettingRepositoryProvider;
use SettingsManager\Provider\CascadingSettingProvider;
use SettingsManager\Registry\SettingDefinitionRegistry;
use MyApp\MySettingRepository;
use MyApp\SensitivePasswordSetting;

// Setup a registry and add settings to it...
$registry = new SettingDefinitionRegistry();
$registry->add(new SensitivePasswordSetting());

// Method #1 - Key/value pairs
$values = [
    'sensitive_password' => '11111',
    'another_setting' => 123,
    // etc..
];

// Method #2
$values = [
    'sensitive_password' => [
        'value'   => '11111',
        'mutable' => false // downstream providers won't be able to override this setting
    ],
    'another_setting' => [
       'value'    => 123,
       'mutable'  => true // downstream providers WILL be able to override this setting
    ]
];

// Mix and match methods #1 and #2
$values = [
    'sensitive_password' => '11111',
    'another_setting' => [
       'value'    => 123,
       'mutable'  => true    
    ]
];

$provider = CascadingSettingProvider::build(
    new DefaultValuesProvider($registry),
    new ArrayValuesProvider($values, $registry, 'config_file'),
    new SettingRepositoryProvider(new MySettingRepository())  
);

$provider->getValueInstance('sensitive_password')->getProviderName(); // will always be 'config_file'
```

### Creating your own provider implementation using the `SettingRepositoryProvider`

Chances are, you'll want to store values in a database.  For convenience, a `SettingRepository` interface
has been bundled as part of this package, along with a `SettingRepositoryProvider`.

```php
use SettingsManager\Contract\SettingRepository;
use SettingsManager\Exception\SettingValueNotFoundException;
use SettingsManager\Provider\SettingRepositoryProvider;

class MySettingRepository implements SettingRepository
{
    /**
     * @var MyDatabaseProvider
     */
    private $dbConnection;
    
    /**
     * MySettingRepository constructor.
     * @param MyDatabaseProvider $dbConnection
     */
    public function __construct(MyDatabaseProvider $dbConnection) 
    {
        $this->dbConnection = $dbConnection;
    }
    
    /**
     * Find a setting value by its name or NULL if it is not found
     *
     * @param string $settingName
     * @return mixed|null
     */
    public function findValue(string $settingName)
    {
        return $this->dbConnection->findValue($settingName);   
    }

    /**
     * Get a setting value by its name or throw an exception if not found
     *
     * @param string $settingName
     * @return mixed
     * @throws SettingValueNotFoundException
     */
    public function getValue(string $settingName)
    {
        if ($this->dbConnection->hasValue($settingName)) {
            return $this->findValue($settingName);
        } else {
            throw SettingValueNotFoundException::fromName($settingName);
        }
    }

    /**
     * List values
     *
     * @return iterable|mixed[]
     */
    public function listValues(): iterable
    {
        return $this->dbConnection->listValues();
    }
}

// Then, use the `SettingRepositoryProvider`
$repository = new MySettingRepository($dbConn);
$provider = new SettingRepositoryProvider($repository);
```

### Handling Exceptions

Exceptions all implement the `SettingException` interface:

| Exception                            | What causes it                                         |
| ------------------------------------ | ------------------------------------------------------ |
| `ImmutableSettingOverrideException`  | If a provider has defined a setting as immutable, and a subsequent provider attempts to override it |
| `InvalidSettingValueException`       | This should be thrown in the case of validation errors |
| `UndefinedSettingException`          | This is thrown from a provider when attempting when attempting to load a setting that hasn't been added to the registry |
| `SettingNameCollissionException`     | This is thrown when attempting to add two definitions to the registry with the same name |
| `SettingValueNotFoundException`      | This is thrown when calling `getValue()` or `getValueInstance()` from a provider on a non-existent setting |

### Considerations for runtime environments

This library facilitates environments such as those provided by Swoole or React in which
setting values are updated at runtime.

If you want to enable this functionality, be sure to always inject whatever setting provider
you are using in your service classes, and lookup settings **during runtime**.

```php
use SettingsManager\Contract\SettingProvider;

class MyServiceClass {
    
    /**
     * @var SettingProvider 
     */
    private $settings;
    
    /**
     * MyServiceClass constructor.
     * @param SettingProvider $provider
     */
    public function __construct(SettingProvider $provider)
    {
        $this->settings = $provider;    
    }
    
    public function doSomethingThatRequiresLookingUpASetting(): void
    {
        // Always lookup the setting value during runtime
        $settingValue = $this->settings->getValue('some_setting');
        
        // do stuff here..
    }
}
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
