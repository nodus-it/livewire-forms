<?php

namespace Nodus\Packages\LivewireForms\Tests\Data;

use Nodus\Packages\LivewireForms\Livewire\FormView;

class UserTestForm extends FormView
{
    public function inputs(): void
    {
        $this->addText('first_name')
            ->setValidations('required');
        $this->addText('email')
            ->setValidations('required|email');
        $this->addCheckbox('admin');
        $this->addDate('birthday');
    }
}
