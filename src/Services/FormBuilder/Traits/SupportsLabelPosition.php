<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\LabelPosition;

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
    protected LabelPosition $labelPosition = LabelPosition::Top;

    /**
     * Returns the current label position
     *
     * @return LabelPosition
     */
    public function getLabelPosition(): LabelPosition
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
        $this->labelPosition = LabelPosition::Right;

        return $this;
    }

    /**
     * Sets the label position to "top"
     *
     * @return $this
     */
    public function setLabelTop(): static
    {
        $this->labelPosition = LabelPosition::Top;

        return $this;
    }
}
