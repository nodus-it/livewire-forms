<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Illuminate\Support\Carbon;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

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

        public function preRenderMutator($date)
        {
            if (empty($date)) {
                return null;
            }

            return Carbon::parse($date)->format('Y-m-d');
        }
    }
