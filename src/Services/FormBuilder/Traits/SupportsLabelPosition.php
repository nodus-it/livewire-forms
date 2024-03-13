<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports label position form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsLabelPosition
{
    /**
     * Label position
     *
     * @var string
     */
    protected string $labelPosition = 'top';

    /**
     * Returns the current label position
     *
     * @return string
     */
    public function getLabelPosition(): string
    {
        return $this->labelPosition;
    }

    /**
     * Sets the label position to "right"
     *
     * @return $this
     */
    public function setLabelRight(): static
    {
        $this->labelPosition = 'right';

        return $this;
    }

    /**
     * Sets the label position to "top"
     *
     * @return $this
     */
    public function setLabelTop(): static
    {
        $this->labelPosition = 'top';

        return $this;
    }
}
