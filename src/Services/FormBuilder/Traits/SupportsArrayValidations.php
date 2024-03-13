<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports array validations form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsArrayValidations
{
    /**
     * Validation rules
     *
     * @var string
     */
    protected string $arrayValidations = '';

    /**
     * Returns the validation rules for the input
     *
     * @return string
     */
    public function getArrayValidations(): string
    {
        return $this->arrayValidations;
    }

    /**
     * Sets the validation rules for the input
     *
     * @param string $validations
     *
     * @return $this
     */
    public function setArrayValidations(string $validations): static
    {
        $this->arrayValidations = $validations;

        return $this;
    }
}
