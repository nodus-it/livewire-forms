<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

class Radio extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;

    /**
     * Radio options array
     *
     * @var array
     */
    protected array $values = [];

    /**
     * Sets the option values
     *
     * @param array $values
     *
     * @return $this
     */
    public function setOptions(array $values)
    {
        $this->values = $values;

        return $this;
    }

    /**
     * Returns the select options array
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->values;
    }
}
