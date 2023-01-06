<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports placeholder form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsPlaceholder
{
    /**
     * Placeholder
     *
     * @var string|null
     */
    protected ?string $placeholder = null;

    /**
     * Returns the translated placeholder
     *
     * @return string|null
     */
    public function getPlaceholder(): string|null
    {
        if ($this->placeholder === null) {
            return $this->getLabel();
        }

        if (empty($this->placeholder)) {
            return null;
        }

        return trans($this->placeholder);
    }

    /**
     * Sets the input placeholder
     *
     * @param string $placeholder
     *
     * @return $this
     */
    public function setPlaceholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Returns if a placeholder exists
     *
     * @return bool
     */
    public function hasPlaceholder(): bool
    {
        if ($this->placeholder === null) {
            return true;
        }

        if (empty($this->placeholder)) {
            return false;
        }

        return true;
    }
}
