<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

/**
 * Supports min max form input trait
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
 */
trait SupportsMinMax
{
    /**
     * The minimum value of the input
     *
     * @var null|mixed
     */
    protected mixed $min = null;

    /**
     * The maximum value of the input
     *
     * @var null|mixed
     */
    protected mixed $max = null;

    /**
     * The step of the input value
     *
     * @var null|mixed|int
     */
    protected mixed $step = null;

    /**
     * Sets the min value of the input
     *
     * @param mixed $min
     *
     * @return $this
     */
    public function setMin(mixed $min): static
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Returns the min value of the input
     *
     * @return mixed|null
     */
    public function getMin(): mixed
    {
        return $this->min;
    }

    /**
     * Sets the max value of the input
     *
     * @param mixed $max
     *
     * @return $this
     */
    public function setMax(mixed $max): static
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Returns the max value of the input
     *
     * @return mixed|null
     */
    public function getMax(): mixed
    {
        return $this->max;
    }

    /**
     * Sets the step size of the value
     *
     * @param int|mixed $step
     *
     * @return $this
     */
    public function setStep(mixed $step): static
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Returns the step size of the value
     *
     * @return int|mixed|null
     */
    public function getStep(): mixed
    {
        return $this->step;
    }
}
