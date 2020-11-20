<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports hint form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsHint
{
    private $hint = null;

    /**
     * Returns the input hint
     *
     * @return int
     */
    public function getHint()
    {
        if ($this->hint != null) {
            return trans($this->hint);
        }

        return $this->hint;
    }

    /**
     * Sets the input hint
     *
     * @param string $hint
     *
     * @return $this
     */
    public function setHint(string $hint)
    {
        $this->hint = $hint;
    }
}
