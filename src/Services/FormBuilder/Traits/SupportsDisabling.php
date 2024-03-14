<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports disabling form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsDisabling
{
    /**
     * Disabling flag
     *
     * @var bool
     */
    protected bool $disabled = false;

    /**
     * Returns if the input is disabled
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * Sets the inputs disabled state
     *
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled = true): static
    {
        $this->disabled = $disabled;

        return $this;
    }
}
