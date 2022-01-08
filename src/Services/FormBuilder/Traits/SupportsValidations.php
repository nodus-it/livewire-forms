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
    protected string $validations = '';

    /**
     * Returns the validation rules for the input
     *
     * @return string
     */
    public function getValidations()
    {
        return $this->validations;
    }

    /**
     * Sets the validation rules for the input
     *
     * @param string $validations
     *
     * @return $this
     */
    public function setValidations(string $validations)
    {
        $this->validations = $validations;

        return $this;
    }

    /**
     * Checks and rewrites the unique validation rule
     *
     * @param Model|null $model
     *
     * @return string
     */
    public function rewriteValidationRules(Model $model = null)
    {
        $rules = explode('|', $this->validations);

        foreach ($rules as $key => $rule) {
            // Rewrite Unique Rule
            if (
                $model !== null &&
                isset($model->id) &&
                str_contains($rule, 'unique') &&
                substr_count($rule, ',') === 1
            ) {
                [$table] = explode(',', $rule);

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

        return implode('|', $rules);
    }
}
