<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports input mode form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsInputMode
{
    /**
     * Array of all allowed input modes
     *
     * @var string[]
     */
    protected array $allowedInputModes = [
        'none',
        'text',
        'decimal',
        'numeric',
        'tel',
        'search',
        'email',
        'url',
    ];

    /**
     * Input mode
     *
     * @var string|null
     */
    protected ?string $inputMode = null;

    /**
     * Returns the input mode
     *
     * @return string|null
     */
    public function getInputMode()
    {
        return $this->inputMode;
    }

    /**
     * Sets the input mode
     *
     * @param string|null $inputMode
     *
     * @return $this
     */
    public function setInputMode(?string $inputMode)
    {
        // Invalid input modes defaults to "text"
        if ($inputMode !== null && !in_array($inputMode, $this->allowedInputModes)) {
            $inputMode = 'text';
        }

        $this->inputMode = $inputMode;

        return $this;
    }
}
