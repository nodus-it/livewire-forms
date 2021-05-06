<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsTranslations;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Select input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 *
 * @method Select setNoneSelectedText(string $translation)
 * @method string getNoneSelectedText()
 * @method Select setNoneResultsText(string $translation)
 * @method string getNoneResultsText()
 * @method Select setSelectAllText(string $translation)
 * @method string getSelectAllText()
 * @method Select setDeselectAllText(string $translation)
 * @method string getDeselectAllText()
 */
class Select extends FormInput
{
    use SupportsMultiple;
    use SupportsSize;
    use SupportsDefaultValue {
        getDefaultValue as parentGetDefaultValue;
    }
    use SupportsValidations;
    use SupportsHint;
    use SupportsTranslations;

    /**
     * Special option value constants
     */
    public const FORCE_OPTION = -100;
    public const NULL_OPTION = -101;

    /**
     * Select options array
     *
     * @var array
     */
    protected array $values = [];

    /**
     * Flag that determines whether an additional option will be added that is invalid,
     * forcing the user to select another option.
     *
     * @var bool
     */
    protected bool $forceOption = false;

    /**
     * Translations array
     *
     * @var array|string[]
     */
    protected array $translations = [
        'deselect_all'  => 'nodus.packages.livewire-forms::forms.bootstrap_select.deselect_all',
        'select_all'    => 'nodus.packages.livewire-forms::forms.bootstrap_select.select_all',
        'none_selected' => 'nodus.packages.livewire-forms::forms.bootstrap_select.none_selected',
        'none_results'  => 'nodus.packages.livewire-forms::forms.bootstrap_select.none_results',
    ];

    /**
     * Sets the option values
     *
     * @param array $values
     *
     * @deprecated use setOptions instead
     *
     * @return $this
     */
    public function setValues(array $values)
    {
        return $this->setOptions($values);
    }

    /**
     * Returns the select options array
     *
     * @deprecated use getOptions instead
     *
     * @return array
     */
    public function getValues()
    {
        return $this->getOptions();
    }

    /**
     * Sets the option values
     *
     * @param array $values
     *
     * @return $this
     */
    public function setOptions(array $values)
    {
        $this->values = Select::castNullSelectOptions($values);

        return $this;
    }

    /**
     * Returns the select options array
     *
     * @return array
     */
    public function getOptions()
    {
        if ($this->forceOption === true) {
            return [self::FORCE_OPTION => static::forceOption()] + $this->values;
        }

        return $this->values;
    }

    /**
     * Returns the default value
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
     * Returns the force option flag
     *
     * @return bool
     */
    public function getForceOption()
    {
        return $this->forceOption;
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
        }

        if (empty($options) && $options !== 0 && $options !== "0") {
            return array_key_first($this->getOptions());
        }

        return $options;
    }

    /**
     * Casts null options to a special value
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

    /**
     * Creates an option array for the force option
     *
     * @return array
     */
    private static function forceOption()
    {
        return static::option(
            trans('nodus.packages.livewire-forms::forms.options.force'),
            'fas fa-fw fa-question-circle text-danger'
        );
    }
}
