<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;

/**
 * Hidden input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Hidden extends FormInput
{
    use SupportsDefaultValue;

    /**
     * Hidden constructor.
     *
     * @param string $name
     * @param        $value
     */
    public function __construct(string $name, string $value)
    {
        parent::__construct($name, '');

        $this->value = $value;
    }

    /**
     * Creates a new form input instance
     *
     * @param string|null $name
     * @param string|null $value
     *
     * @return FormInput|static
     */
    public static function create(string $name, string $value = null)
    {
        return new static($name, $value);
    }
}
