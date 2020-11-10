<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Illuminate\Support\Carbon;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

    /**
     * Time input class
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder
     */
    class Time extends FormInput
    {
        use SupportsDefaultValue;
        use SupportsValidations;
        use SupportsSize;

        /**
         * Post validation mutator handler
         *
         * @param string $time
         *
         * @return Carbon|false
         */
        public function postValidationMutator(?string $time)
        {
            if (empty($time)) {
                return null;
            }

            return Carbon::parse($time);
        }

        public function preRenderMutator($time)
        {
            if (empty($time)) {
                return null;
            }

            return Carbon::parse($time)->format('H:i:s');
        }

        // Todo add seconds (step) support
    }
