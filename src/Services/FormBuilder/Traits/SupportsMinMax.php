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
    protected $min = null;

    /**
     * The maximum value of the input
     *
     * @var null|mixed
     */
    protected $max = null;

    /**
     * The step of the input value
     *
     * @var null|mixed|int
     */
    protected $step = null;

    /**
     * Sets the min value of the input
     *
     * @param mixed $min
     *
     * @return $this
     */
    public function setMin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Returns the min value of the input
     *
     * @return mixed|null
     */
    public function getMin()
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
    public function setMax($max)
    {
        $this->max = $max;

        return $this;
    }

    /**
     * Returns the max value of the input
     *
     * @return mixed|null
     */
    public function getMax()
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
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Returns the step size of the value
     *
     * @return int|mixed|null
     */
    public function getStep()
    {
        return $this->step;
    }
}
