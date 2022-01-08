<?php

namespace Nodus\Packages\LivewireForms\Tests\data;

use Nodus\Packages\LivewireForms\Livewire\FormView;

class UserTestForm extends FormView
{
    public function inputs()
    {
        $this->addText('first_name')
            ->setValidations('required');
        $this->addText('email')
            ->setValidations('required|email');
        $this->addCheckbox('admin');
    }
}