<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports hint form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsHint
{
    /**
     * Input hint
     *
     * @var string|null
     */
    private ?string $hint = null;

    /**
     * Returns the input hint
     *
     * @return string|null
     */
    public function getHint(): ?string
    {
        if ($this->hint === null) {
            return null;
        }

        return trans($this->hint);
    }

    /**
     * Sets the input hint
     *
     * @param string $hint
     *
     * @return $this
     */
    public function setHint(string $hint): static
    {
        $this->hint = $hint;

        return $this;
    }
}
