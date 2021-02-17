# Livewire Forms
[![License](https://poser.pugx.org/nodus-it/livewire-forms/license)](//packagist.org/packages/nodus-it/livewire-forms)
[![Latest Unstable Version](https://poser.pugx.org/nodus-it/livewire-forms/v/unstable)](//packagist.org/packages/nodus-it/livewire-forms)
[![Total Downloads](https://poser.pugx.org/nodus-it/livewire-forms/downloads)](//packagist.org/packages/nodus-it/livewire-forms)

_An awesome package for easy dynamic forms with livewire._

The following inputs are currently supported:

- Checkbox
- Code (powered by CodeMirror.js)
- Color
- Date
- Datetime (composed of a date and a time input)
- Decimal (own implementation)
- File
- Hidden
- Number
- Password
- RichTextarea (powered by Quill.js)
- Select
- Text
- Textarea
- Time


**This package is currently being developed and is still in testing**

## Roadmap
### Near term
- Support more properties
    - min
    - max
    - step
    - placeholder

### Future
- All Inputs
    - improve multiple support
    - check if we should support more properties
        - pattern
        - required
        - spellcheck
        - size
        - maxlength
        - minlength
        - readonly 
        - disabled
        - ...
    - custom property system
- Extensibility
    - override default classes (class overload)
    - external extensions
        - remote select
        - more?
- JS Handling
    - own JS class
    - own blade directive
- Post Handling
	- Validation: add support for array validation rules
