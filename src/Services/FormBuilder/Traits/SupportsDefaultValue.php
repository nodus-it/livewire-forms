<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

    use Carbon\Carbon;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;

    /**
     * Supports default value form input trait
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
     */
    trait SupportsDefaultValue
    {
        /**
         * The default value of the input
         *
         * @var null|mixed
         */
        protected $value = null;

        /**
         * Sets the default value
         *
         * @param mixed $value
         *
         * @return $this
         */
        public function setDefaultValue($value)
        {
            if (($this instanceof Date || $this instanceof Time) && !$value instanceof Carbon) {
                $value = Carbon::parse($value);
            }

            $this->value = $value;

            return $this;
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
            if ($value !== '' && $value !== null) {
                return $value;
            }

            return $this->getDefaultValue();
        }

        /**
         * Returns the default value
         *
         * @return mixed
         */
        public function getDefaultValue()
        {
            return $this->value;
        }
    }
