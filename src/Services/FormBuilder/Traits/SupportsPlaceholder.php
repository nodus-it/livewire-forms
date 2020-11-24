<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

    /**
     * Supports placeholder form input trait
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
     */
    trait SupportsPlaceholder
    {
        /**
         * Placeholder text
         *
         * @var string
         */
        protected string $placeholder = '';

        /**
         * Returns the placeholder text
         *
         * @return string
         */
        public function getPlaceholder()
        {
            return $this->placeholder;
        }

        /**
         * Sets the placeholder text
         *
         * @param string $placeholder
         *
         * @return $this
         */
        public function setPlaceholder(string $placeholder)
        {
            $this->placeholder = $placeholder;

            return $this;
        }
    }
