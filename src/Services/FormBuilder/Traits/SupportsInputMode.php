<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\InputMode;

/**
 * Supports input mode form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsInputMode
{
    /**
     * Input mode
     *
     * @var InputMode|null
     */
    protected ?InputMode $inputMode = null;

    /**
     * Returns the input mode
     *
     * @return string|null
     */
    public function getInputMode(): ?InputMode
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
    public function setInputMode(InputMode|string|null $inputMode): static
    {
        if (is_string($inputMode)) {
            $inputMode = InputMode::tryFrom($inputMode) ?? InputMode::Text;
        }

        $this->inputMode = $inputMode;

        return $this;
    }
}
