# Changelog

All notable changes to *Settings Manager* will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [1.1] - 2022-02-11
### Fixed
- PHP 8.0 compatibility: Removed `final` keyword from `AbstractSetting::requireConstant()`

## [1.0] - 2019-10-28
### Added
- New exception: `UndefinedSettingException` (thrown when attempting to get a definition from the registry that doesn't exist)
- Default parameter values for constructor in `ArrayValuesProvider`
- New `getValue()` method to `SettingRepository` (throws exception on failure)
### Changed
- **BC BREAK** - Renamed `ArraySettingProvider` -> `ArrayValuesProvider`
- Test Name: `AbstractSettingTest` -> `AbstractSettingDefinitionTest`
- Removed unnecessary lines from `AbstractSettingDefinitionTest`

## [0.9] - 2019-10-22
### Added
- `SettingProviderInterface::findValue()` shortcut method to get the value directly
- Full suite of tests
- Default implementation of `processValue()` method in `AbstractSettingDefinition` class (to make validation truly optional)
- `final` keywords to a number of methods in multiple classes
### Changed
- **BC BREAK** - Renamed `SettingProviderInterface::findValue()` to `findSettingValue()` 
- **BC BREAK** - Moved `AbstractSetting` to the `Model` namespace and removed the `Helper` namespace
- **BC BREAK** - Renamed `SettingsProviderInterface` to `SettingProviderInterface` for consistency
- **BC BREAK** - Renamed `DefaultProvider` to `DefaultValuesProvider` for clarity
- **BC BREAK** - Renamed classes: 
    - `SettingInterface` to `SettingDefinitionInterface`
    - `AbstractSetting` to `AbstractSettingDefinition`
- **BC BREAK** - Renamed `SettingValue::getSettingName()` to `SettingValue::getName()`
- **BC BREAK** - Removed `...Interface` suffix from all interfaces
- Change in default behavior: Assume all settings are sensitive by default
- Adding multiple settings with the same name throws a `SettingNameCollisionException` instead of a half-baked
  `ImmutableSettingOverrideException`
- Added common interface for all exceptions: `SettingException`

### Removed
- `SettingDefinitionRegistry::addItem()` (seemed redundant with the `add()` method)
- `SettingValueInterface` (seemed redundant with concrete class implementation)

### Fixed
- Behavior inconsistency in `CascadingSettingProvider` class.  Values will be initialized immediately upon being
  loaded

## [0.3] - 2018-09-18
### Added
- `SettingInterface::isSensitive()` for denoting sensitive values
### Fixed
- Code style in SettingInterface

## [0.2.1] - 2018-09-13
### Fixed
- Fixed bugs in constructor for `ArraySettingProvider`

## [0.2] - 2018-09-13
### Fixed
- Fixed bug in `ArraySettingProvider`; setting instances of `SettingValue` correctly
### Added
- Allow setting `mutable` and `value` sub-array keys in each `ArraySettingProvider` item

## [0.1] - 2018-08-16 
### Added
- Everything; initial development release
