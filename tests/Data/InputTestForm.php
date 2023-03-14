<?php

namespace Nodus\Packages\LivewireForms\Tests\Data;

use Illuminate\Validation\Validator;
use Nodus\Packages\LivewireForms\Livewire\FormView;

class InputTestForm extends FormView
{
    public function inputs()
    {
        $this->addCheckbox('checkbox_input');
        $this->addCode('code_input');
        $this->addColor('color_input');
        $this->addDate('date_input');
        $this->addDateTime('date_time_input');
        $this->addDecimal('decimal_input');
        $this->addFile('file_input');
        $this->addHidden('hidden_input', '');
        $this->addHtml('<b>HTML Content 1</b>');
        $this->addHtml('<b>HTML Content 2</b>', 'html_test');
        $this->addNumber('number_input');
        $this->addPassword('password_input');
        $this->addRadio('radio_input');
        $this->addRichTextarea('rich_textarea_input');
        $this->addSelect('select_input');
        $this->addText('text_input');
        $this->addTextarea('textarea_input');
        $this->addTime('time_input');

        $this->addText('default_input')
            ->setDefaultValue('Thats the default');

        $this->addText('required_input')
            ->setValidations('required');
        $this->addText('min_input')
            ->setValidations('required|min:5');
    }

    public function submit(array $values)
    {
        \Illuminate\Support\Facades\Validator::make(
            $values,
            ['required_input' => 'string|min:5']
        )->validate();
    }

    protected function submitValidationExceptionHandler(Validator $validator)
    {
        $fields = array_keys($validator->failed());

        session()->put('validation-errors', $fields);
    }
}
