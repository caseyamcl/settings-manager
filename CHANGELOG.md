# Changelog

All notable changes to *Settings Manager* will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [UNRELEASED] - 2019-10-20
### Added
- `SettingProviderInterface::findValue()` shortcut method to get the value directly
- Full suite of tests
### Changed
- **BC BREAK** - Renamed `SettingProviderInterface::findValue()` to `findSettingValue()` 
- **BC BREAK** - Moved `AbstractSetting` to the `Model` namespace and removed the `Helper` namespace
- **BC BREAK** - Renamed `SettingsProviderInterface` to `SettingProviderInterface` for consistency
- **BC BREAK** - Renamed `DefaultProvider` to `DefaultValuesProvider` for clarity
- **BC BREAK** - Renamed classes: 
    - `SettingInterface` to `SettingDefinitionInterface`
    - `AbstractSetting` to `AbstractSettingDefinition`
- Change in default behavior: Assume all settings are sensitive by default
- Adding multiple settings with the same name throws a `SettingNameCollisionException` instead of a half-baked
  `ImmutableSettingOverrideException`
- Added common interface for all exceptions: `SettingException`

### Removed
- `SettingDefinitionRegistry::addItem()` (seemed unused)

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
