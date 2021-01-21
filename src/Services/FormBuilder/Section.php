<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;

class Section extends FormInput
{
    use SupportsSize;

    public function __construct(string $label)
    {
        parent::__construct($label, $label);
        $this->setSize(4);
    }

    /**
     * Renders the form input
     *
     * @param bool $initialRender
     *
     * @return  string
     */
    public function render(bool $initialRender = false)
    {
        return view('section', ['input' => $this, 'initialRender' => $initialRender])->render();
    }
}
