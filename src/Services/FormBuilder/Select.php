<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * TODO Select input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Select extends FormInput
{
    use SupportsMultiple;
    use SupportsSize;
    use SupportsDefaultValue {
        getDefaultValue as parentGetDefaultValue;
    }
    use SupportsValidations;

    /**
     * Spezial Option Value Konstante
     */
    public const FORCE_OPTION = -100;
    public const NULL_OPTION = -101;

    /**
     * Select Options Array
     *
     * @var array
     */
    protected array $values = [];

    /**
     * Flag das festlegt ob eine zusätzliche Option hinzugefügt wird die ungültig ist um den Nutzer zu zwingen
     * eine andere Option auszuwählen (funktioniert nur bei Non-Remote-Selects)
     *
     * @var bool
     */
    protected bool $forceOption = false;

    /**
     * Castet null Options zu einem speziellen Value
     *
     * @param array $options
     *
     * @return array
     */
    public static function castNullSelectOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if ($key === "") {
                unset($options[ $key ]);
                $options[ Select::NULL_OPTION ] = $option;
            }
        }

        return $options;
    }

    /**
     * Sets the option values
     *
     * @param array $values
     *
     * @return $this
     */
    public function setValues(array $values)
    {
        $this->values = Select::castNullSelectOptions($values);

        return $this;
    }

    /**
     * Returns the select options array
     *
     * @return array
     */
    public function getValues()
    {
        if ($this->forceOption === true) {
            return [
                    self::FORCE_OPTION => static::option(
                        trans('nodus.content_handler::select.options.force'),
                        'fas fa-question-circle text-danger'
                    )
                ] + $this->values;
        }

        return $this->values;
    }

    /**
     * Gibt den Default Value zurück, überschreibt die Funktion aus dem SupportsDefaultValue Trait
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        // Wenn die Force Option aktiviert ist und der Default Value nicht geändert
        // wurde ist der Default Value die Force Option
        if ($this->getForceOption() === true && $this->value === null) {
            return Select::FORCE_OPTION;
        }

        return $this->parentGetDefaultValue();
    }

    /**
     * Gibt das Force Option Flag zurück
     *
     * @return bool
     */
    public function getForceOption()
    {
        return $this->forceOption;
    }

    /**
     * Sets the force option flag
     *
     * @param bool $forceOption
     *
     * @return $this
     */
    public function setForceOption(bool $forceOption = true)
    {
        $this->forceOption = $forceOption;

        return $this;
    }

    /**
     * Pre render mutator handler
     * 
     * @param $options
     *
     * @return array|int|string|null
     */
    public function preRenderMutator($options)
    {
        if ($this->getMultiple()) {
            return Arr::wrap($options);
        } elseif (empty($options)) {
            return array_key_first($this->getValues());
        }

        return $options;
    }

    /**
     * Creates an option array
     *
     * @param string      $label
     * @param string|null $icon
     *
     * @return array
     */
    public static function option(string $label, ?string $icon = null)
    {
        return compact('label', 'icon');
    }
}
