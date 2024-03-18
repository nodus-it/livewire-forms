<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsOptions;
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
    use SupportsValidations {
        rewriteValidationRules as parentRewriteValidationRules;
    }
    use SupportsHint;
    use SupportsTranslations;
    use SupportsDisabling;
    use SupportsOptions {
        getOptions as parentGetOptions;
        setOptions as parentSetOptions;
    }

    /**
     * Special option value constants
     */
    public const FORCE_OPTION = -100;
    public const NULL_OPTION = -101;

    /**
     * Flag that determines whether an additional option will be added that is invalid,
     * forcing the user to select another option.
     *
     * @var bool
     */
    protected bool $forceOption = false;

    /**
     * Icon CSS classes for the force option
     *
     * @var string|null
     */
    protected ?string $forceOptionIconClasses = null;

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
     * Sets the options array
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options): static
    {
        return $this->parentSetOptions(Select::castNullSelectOptions($options));
    }

    /**
     * Returns the select options array
     *
     * @return array
     */
    public function getOptions(): array
    {
        $options = $this->parentGetOptions();

        if ($this->getForceOption() === true) {
            return [self::FORCE_OPTION => $this->forceOption()] + $options;
        }

        return $options;
    }

    /**
     * Returns whether the given option key is a valid option
     *
     * @param mixed $optionKey
     *
     * @return bool
     */
    public function isValidOption(mixed $optionKey): bool
    {
        return isset($this->getOptions()[$optionKey]);
    }

    /**
     * Returns the default value
     *
     * @return mixed
     */
    public function getDefaultValue(): mixed
    {
        if ($this->getForceOption() === true && $this->value === null) {
            return Select::FORCE_OPTION;
        }

        $default = $this->parentGetDefaultValue();

        // only values that are in the options array are allowed as defaults
        if (!is_array($default) && !$this->isValidOption($default)) {
            return null;
        }

        return $default;
    }

    /**
     * Sets the force option flag
     *
     * @param bool        $forceOption
     * @param string|null $iconClasses
     *
     * @return $this
     */
    public function setForceOption(bool $forceOption = true, ?string $iconClasses = 'fas fa-fw fa-question-circle text-danger nodus-force-icon'): static
    {
        $this->forceOption = $forceOption;
        $this->forceOptionIconClasses = $iconClasses;

        return $this;
    }

    /**
     * Returns the force option flag
     *
     * @return bool
     */
    public function getForceOption(): bool
    {
        return $this->forceOption === true && $this->getMultiple() === false;
    }

    /**
     * Pre render mutator handler
     *
     * @param mixed $options
     *
     * @return mixed
     */
    public function preRenderMutator(mixed $options): mixed
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
     * Pre validation mutator handler
     *
     * @param mixed $options
     *
     * @return mixed|null
     */
    public function preValidationMutator(mixed $options): mixed
    {
        $options = Arr::wrap($options);

        foreach ($options as $key => $option) {
            $option = $this->preValidationOptionMutator($option);

            if ($option === false) {
                unset($options[$key]);
                continue;
            }

            $options[$key] = $option;
        }

        if ($this->getMultiple() === false) {
            return Arr::first($options);
        }

        return array_values($options);
    }

    /**
     * Pre validation mutator for a single given option
     *
     * @param string|int|null $option
     *
     * @return string|int|bool|null
     */
    public function preValidationOptionMutator(string|int|null $option): string|int|bool|null
    {
        if (intval($option) === Select::NULL_OPTION) {
            return null;
        }

        // only values that are in the options array are allowed
        if (!$this->isValidOption($option)) {
            return false;
        }

        return $option;
    }

    /**
     * Casts null options to a special value
     *
     * @param array $options
     *
     * @return array
     */
    public static function castNullSelectOptions(array $options): array
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
     * Creates an option array for the force option
     *
     * @return array
     */
    private function forceOption(): array
    {
        return static::option(
            trans('nodus.packages.livewire-forms::forms.options.force'),
            $this->forceOptionIconClasses
        );
    }

    /**
     * Checks and rewrites the unique validation rule
     *
     * @param Model|null $model
     *
     * @return string
     */
    public function rewriteValidationRules($model = null): string
    {
        if ($this->getForceOption() === true) {
            if (empty($this->validations)) {
                $this->validations = 'required_option';
            } else {
                $this->validations .= '|required_option';
            }
        }

        return $this->parentRewriteValidationRules($model);
    }
}
