<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Select input class
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
    use SupportsHint;

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
     * Gibt das Force Option Flag zurück
     *
     * @return bool
     */
    public function getForceOption()
    {
        return $this->forceOption;
    }

    /**
     * Sets the none selected text translation
     *
     * @param string $translation
     *
     * @return $this
     */
    public function setNoneSelectedText(string $translation)
    {
        $this->translations[ 'none_selected' ] = $translation;

        return $this;
    }

    /**
     * Returns the none selected text
     *
     * @return string
     */
    public function getNoneSelectedText()
    {
        return trans($this->translations[ 'none_selected' ]);
    }

    /**
     * Sets the none results text translation
     *
     * @param string $translation
     *
     * @return $this
     */
    public function setNoneResultsText(string $translation)
    {
        $this->translations[ 'none_results' ] = $translation;

        return $this;
    }

    /**
     * Returns the none results text
     *
     * @return string
     */
    public function getNoneResultsText()
    {
        return trans($this->translations[ 'none_results' ]);
    }

    /**
     * Sets the select all text translation
     *
     * @param string $translation
     *
     * @return $this
     */
    public function setSelectAllText(string $translation)
    {
        $this->translations[ 'select_all' ] = $translation;

        return $this;
    }

    /**
     * Returns the select all text
     *
     * @return string
     */
    public function getSelectAllText()
    {
        return trans($this->translations[ 'select_all' ]);
    }

    /**
     * Sets the deselect all text translation
     *
     * @param string $translation
     *
     * @return $this
     */
    public function setDeselectAllText(string $translation)
    {
        $this->translations[ 'deselect_all' ] = $translation;

        return $this;
    }

    /**
     * Returns the deselect all text
     *
     * @return string
     */
    public function getDeselectAllText()
    {
        return trans($this->translations[ 'deselect_all' ]);
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

        if (empty($options)) {
            return array_key_first($this->getValues());
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
}
