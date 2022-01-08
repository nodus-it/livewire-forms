<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
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
    use SupportsHint;

    /**
     * Checkbox constructor
     *
     * @param string      $name
     * @param string|null $label
     */
    public function __construct(string $name, ?string $label = null)
    {
        $this->setDefaultValue(false);

        parent::__construct($name, $label);
    }

    /**
     * Returns the value of the underlying attribute if such exists or the default otherwise
     *
     * @param mixed|null $value
     *
     * @return mixed|string
     */
    public function getValue($value = null)
    {
        if (!empty($value) || $value === false) {
            return $value;
        }

        return $this->getDefaultValue();
    }
}
