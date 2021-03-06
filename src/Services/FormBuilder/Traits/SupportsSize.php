<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

    /**
     * Supports size form input trait
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
     */
    trait SupportsSize
    {
        /**
         * Input size
         *
         * @var int
         */
        protected int $size = 2;

        /**
         * Returns the input size (dependant on the theme)
         *
         * @return int
         */
        public function getSize()
        {
            if (config('livewire-forms.theme') === 'bootstrap') {
                return $this->size * 3;
            }

            return $this->size;
        }

        /**
         * Sets the input size (values: 1-4)
         *
         * @param int $size
         *
         * @return $this
         */
        public function setSize(int $size)
        {
            $this->size = min(4, max(1, $size));

            return $this;
        }
    }
