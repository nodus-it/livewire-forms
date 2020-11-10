<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Checkbox input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Checkbox extends FormInput
{
    use SupportsSize;
    use SupportsDefaultValue;
    use SupportsValidations;

    /**
     * Checkbox constructor
     *
     * @param string $label
     * @param string $name
     */
    public function __construct(string $name, string $label)
    {
        $this->setDefaultValue(false);

        parent::__construct($name, $label);
    }
}
