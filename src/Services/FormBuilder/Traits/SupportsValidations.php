<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Traits;

    use Illuminate\Database\Eloquent\Model;

    /**
     * Supports validations form input trait
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder\Traits
     */
    trait SupportsValidations
    {
        /**
         * Validation rules
         *
         * @var string
         */
        protected array $validations = [];

        /**
         * Returns the validation rules for the input
         *
         * @return array
         */
        public function getValidations()
        {
            return $this->validations;
        }

        /**
         * Sets the validation rules for the input
         *
         * @param string|array $validations
         *
         * @return $this
         */
        public function setValidations($validations)
        {
            if (is_string($validations)) {
                $validations = explode('|', $validations);
            }

            if (is_array($validations)) {
                $this->validations = $validations;
            }

            return $this;
        }

        /**
         * Checks and rewrites the unique validation rule
         *
         * @param Model|null $model
         *
         * @return array
         */
        public function rewriteValidationRules($model = null)
        {
            $rules = $this->getValidations();

            if ($model === null || !isset($model->id) || $model->id === null) {
                return $rules;
            }

            foreach ($rules as $key => $rule) {
                // Rewrite rule objects
                if (is_object($rule) && method_exists($rule, '__toString')) {
                    $rules[ $key ] = $rule->__toString();
                }

                // Rewrite Unique Rule
                if (is_string($rule) && str_contains($rule, 'unique') && substr_count($rule, ',') === 1) {
                    [$table, $column] = explode(',', $rule);

                    $table = str_replace('unique:', '', $table);
                    if (substr_count($table, '.') > 0) {
                        $table = explode('.', $table);
                        $table = last($table);
                    }

                    if ($model->getTable() === $table) {
                        $rules[ $key ] = $rule . ',' . $model->id;
                    }
                }
            }

            return $rules;
        }
    }
