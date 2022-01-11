<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Carbon;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Date Time input class
 *
 * @package  Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class DateTime extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;

    /**
     * Pre validation mutator handler
     *
     * @param array|null $date
     *
     * @return Carbon|null
     */
    public function preValidationMutator(?array $date)
    {
        if (empty($date)) {
            return null;
        }

        $date = $date[ 'datetime' ];

        return Carbon::parse($date);
    }

    /**
     * Returns the array with values used by this input
     *
     * @param Carbon|array|string|null $value
     *
     * @return array
     */
    public function getArrayValue($value = null)
    {
        if (empty($value)) {
            $value = $this->getDefaultValue();
        }

        if (!empty($value) && !is_array($value)) {
            $value = Carbon::parse($value);
        }

        if (!is_array($value)) {
            return [
                'date'     => null,
                'time'     => null,
                'datetime' => $value,
            ];
        }

        return $value;
    }

    /**
     * Returns the value of the underlying attribute if such exists or the default otherwise
     *
     * @param mixed|null $value
     *
     * @return array
     */
    public function getValue($value = null)
    {
        $value = $this->getArrayValue($value);

        $value[ 'date' ] = $this->getDateValue($value[ 'date' ] ?? $value[ 'datetime' ] ?? null);
        $value[ 'time' ] = $this->getTimeValue($value[ 'time' ] ?? $value[ 'datetime' ] ?? null);
        $value[ 'datetime' ] = trim($value[ 'date' ] . ' ' . $value[ 'time' ]);

        return $value;
    }

    /**
     * Returns the date value of the underlaying datetime
     *
     * @param Carbon|string|null $value
     *
     * @return string|null
     */
    public function getDateValue($value = null)
    {
        if ($value === null) {
            return null;
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Returns the time value of the underlaying datetime
     *
     * @param Carbon|string|null $value
     *
     * @return string|null
     */
    public function getTimeValue($value = null)
    {
        if ($value === null) {
            return null;
        }

        // Omit seconds
        return Carbon::parse($value)->setSeconds(0)->format('H:i');
    }
}
