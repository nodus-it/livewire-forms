<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Carbon;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMinMax;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsPlaceholder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;
use Throwable;

/**
 * Date input class
 *
 * @package  Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Date extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsPlaceholder;
    use SupportsMinMax;
    use SupportsDisabling;

    /**
     * Date constructor.
     *
     * @param string      $name
     * @param string|null $label
     */
    public function __construct(string $name, ?string $label = null)
    {
        // Only as fallback for browsers like safari, see https://caniuse.com/input-datetime
        $this->setPlaceholder('YYYY-MM-DD');

        parent::__construct($name, $label);
    }

    /**
     * Post validation mutator handler
     *
     * @param string|null $date
     *
     * @return Carbon|null
     */
    public function postValidationMutator(?string $date): ?Carbon
    {
        if (empty($date)) {
            return null;
        }

        return Carbon::parse($date);
    }

    /**
     * Pre render mutator handler
     *
     * @param Carbon|string|null $date
     *
     * @return string|null
     */
    public function preRenderMutator($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            return Carbon::parse($date)->format('Y-m-d');
        } catch (Throwable) {
            return $date;
        }
    }

    /**
     * Returns the max value of the input
     *
     * @return string|null
     */
    public function getMax(): ?string
    {
        if ($this->max === null) {
            return null;
        }

        if (!$this->max instanceof Carbon) {
            $this->max = Carbon::parse($this->max);
        }

        return $this->max->toDateString();
    }

    /**
     * Returns the min value of the input
     *
     * @return string|null
     */
    public function getMin(): ?string
    {
        if ($this->min === null) {
            return null;
        }

        if (!$this->min instanceof Carbon) {
            $this->min = Carbon::parse($this->min);
        }

        return $this->min->toDateString();
    }
}
