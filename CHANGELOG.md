# Changelog

All notable changes to *Settings Manager* will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [UNRELEASED] - 2019-10-20
### Added
- `SettingProviderInterface::findValue()` shortcut method to get the value directly
### Changed
- **BC BREAK** - Renamed `SettingProviderInterface::findValue()` to `findSettingValue()` 
- **BC BREAK** - Moved `AbstractSetting` to the `Model` namespace and removed the `Helper` namespace
### Removed
- `SettingDefinitionRegistry::addItem()` (seemed unused)

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
