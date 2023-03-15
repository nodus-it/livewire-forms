# Changelog

All notable changes to `livewire-forms` will be documented in this file

## 0.7.0 - TBA

- Changed the minimum PHP version to v8.1
- Added a new form input trait ``SupportsLabelPosition`` (for checkboxes)
- Added a new form input trait ``SupportsArrayValidations`` (for inputs that support the ``multiple`` property)
- Added PHP types to most of the code
- Added ``addNewLine`` shortcut to the form builder
- Label positions, currencies and input modes are now represented by enums
- Improved the decimal Input so beside currencies all sorts of custom units are possible now

## 0.6.0 - 2022-12-18

- Added support for PHP v8.2
- Added the option to use HTML inside input labels

## 0.5.0 - 2022-05-04

- Added support for PHP v8.1
- Changed the minimum PHP version to v8.0
- Restructured config (some config values are now defined through the ``livewire-core`` package)
- Refactored the javascript form initialization handling
- Added a new form input trait ``SupportsMinMax``
- Added support for dynamic option creation for selects
- Added ``multiple``  support for the file input

## Older releases
For older releases is no changelog documented. Refer to the commit history in case you need further details for these versions.
