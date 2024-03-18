# Changelog

All notable changes to `livewire-forms` will be documented in this file

## 0.9.0 - 2024-03-XX

- Added more options for the rich-textarea input
- Added a new form input trait ``SupportsDisabling`` (for inputs that support the ``disabled`` property)
- Adjusted the default behaviour of the decimal input, added separate currency input to mimic the previous default behaviour
- Changed the getValue method, added getRawValue method with the previous behaviour
- Fixed missing validation rules exception in case no validations are defined

## 0.8.0 - 2024-03-13

- Changed the minimum PHP version to v8.1
- Added ``addNewLine`` shortcut to the form builder
- Label positions, currencies and input modes are now represented by enums
- Improved the decimal Input so beside currencies all sorts of custom units are possible now
- Fixed that the force option of selects has no longer any effect in multi selects
- Fixed the invalid value problem for dynamically changing select options

## 0.7.0 - 2024-03-13

- Added a new form input trait ``SupportsLabelPosition`` (for checkboxes)
- Added a new form input trait ``SupportsArrayValidations`` (for inputs that support the ``multiple`` property)
- Added PHP types to most of the code
- Added the option to set the rows of a textarea
- Fixed min/max support for date inputs
- Fixed initialization of code and richtextarea inputs when dynamically added to the form
- Fixed the initInputs function for dynamically removed forms
- Fixed that array validations are now only checked if there are some defined
- Fixed hint for label position mode right

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
