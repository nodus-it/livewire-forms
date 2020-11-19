<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Illuminate\Support\Carbon;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
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

        /**
         * Post validation mutator handler
         *
         * @param string $date
         *
         * @return Carbon|false
         */
        public function postValidationMutator(?string $date)
        {
            if (empty($date)) {
                return null;
            }

            return Carbon::parse($date);
        }

        public function getDateValue($value = null)
        {
            $value = $this->getValue($value);

            if($value === null) {
                return null;
            }

            return Carbon::parse($value)->format('Y-m-d');
        }

        public function getTimeValue($value = null)
        {
            $value = $this->getValue($value);

            if($value === null) {
                return null;
            }

            return Carbon::parse($value)->format('H:i:s');
        }

        public function getDateId()
        {
            return $this->getId() . '_date';
        }

        public function getTimeId()
        {
            return $this->getId() . '_time';
        }
    }
