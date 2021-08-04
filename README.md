# Livewire Forms
[![License](https://poser.pugx.org/nodus-it/livewire-forms/license)](//packagist.org/packages/nodus-it/livewire-forms)
[![Latest Stable Version](https://poser.pugx.org/nodus-it/livewire-forms/v/stable)](//packagist.org/packages/nodus-it/livewire-forms)
[![Total Downloads](https://poser.pugx.org/nodus-it/livewire-forms/downloads)](//packagist.org/packages/nodus-it/livewire-forms)

_An awesome package for easy dynamic forms with **Laravel Livewire** and **Bootstrap**._

Some special input types may require external javascript dependencies (besides Bootstrap).

The following inputs are currently supported:

- Checkbox
- Code (requires CodeMirror.js)
- Color
- Date
- Datetime (composed of a date and a time input)
- Decimal/Money (own implementation)
- File
- Hidden
- Number
- Password
- Radio
- RichTextarea (requires Quill.js)
- Select (requires bootstrap-select)
- Text
- Textarea
- Time
- _It is also possible to create your own custom input types_...


**This package is currently under development, so be careful if you want to use this package in production.**

## Usage
### Minimal form view example
````php
class UserForm extends FormView
{
    public function inputs()
    {
        $this->addText('name')
            ->setValidations('required|unique:users,name')
            ->setSize(4);
        $this->addSelect('country')
            ->setOptions(['DE' => ['label' => 'DE']])
            ->setValidations('required')
            ->setDefaultValue('DE');
        $this->addInput(CustomFileUploadInput::class, 'picture')

        $this->addSection('tenants.views.contact');
        $this->addText('email')
            ->setValidations('required|email');
        $this->addText('phone')
            ->setValidations('required');
    }

    public function submitCreate(array $values)
    {
        User::query()->create($values);
    
        return redirect()->back();
    }

    public function submitUpdate(array $values, User $user)
    {
        $user->update($values);
        
        return redirect()->back();
    }
}
````

### View integration
Add your created form like any other Livewire component to your blade templates:
````html
<livewire:user-form />
````

In case you want to prepopulate the input fields with an existing dataset, pass the desired model or array as attribute:
````html
<livewire:user-form :model-or-array="$user" />
````

If you need to pass some custom data inside your forms, you can do so by passing additional data as array via the "additional-view-parameter" attribute:
````html
<livewire:user-form :additional-view-parameter="['customKey' => 'customData']" />
````

All the given additional parameter can then be acccess directly in your form like so:
````php
public function submitCreate(array $values)
{
    $this->customKey // resolves via __get() Magic to "customData"
}
````

## Roadmap/TODO
- All Inputs
  - improve multiple support
  - check if we should support more properties
  - custom property system
- New inputs
  - High-level input types e.g. Phone or Email (incl. automatic validation and input mode defaults)
  - Maybe add also support for native select inputs
- Extensibility
  - override default classes (class overload)
  - external extensions (e.g. remote select)
- JS Handling
  - own JS class
  - maybe own blade directive
- Post Handling
  - Validation: add support for array validation rules
  - Improve validation exception handling if such is thrown inside the submit methods
- Find another solution for the integration of external plugins like bootstrap-select than using "wire:ignore" due to several drawbacks that come with this, such as no possibility for dynamic select option updates.