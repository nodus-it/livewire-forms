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
         * Post validation mutator handler
         *
         * @param array $date
         *
         * @return Carbon|false
         */
        public function postValidationMutator(?array $date)
        {
            if (empty($date)) {
                return null;
            }

            $date = $date[ 'datetime' ];

            return Carbon::parse($date);
        }

        public function getArrayValue($value = null)
        {
            if (empty($value)) {
                $value = $this->getDefaultValue();
            }

            if ( !empty($value) && !is_array($value)) {
                $value = Carbon::parse($value);
            }

            if ( !is_array($value)) {
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
         * @return mixed|string
         */
        public function getValue($value = null)
        {
            $value = $this->getArrayValue($value);

            $value[ 'date' ] = $this->getDateValue($value[ 'date' ] ?? $value[ 'datetime' ] ?? null);
            $value[ 'time' ] = $this->getTimeValue($value[ 'time' ] ?? $value[ 'datetime' ] ?? null);
            $value[ 'datetime' ] = trim($value[ 'date' ] . ' ' . $value[ 'time' ]);

            return $value;
        }

        public function getDateValue($value = null)
        {
            if ($value === null) {
                return null;
            }

            return Carbon::parse($value)->format('Y-m-d');
        }

        public function getTimeValue($value = null)
        {
            if ($value === null) {
                return null;
            }

            return Carbon::parse($value)->format('H:i:s');
        }
    }
