<?php

namespace Nodus\Packages\LivewireForms\Livewire;

use ArrayAccess;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Nodus\Packages\LivewireCore\SupportsAdditionalViewParameters;
use Nodus\Packages\LivewireForms\Services\FormBuilder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\FormInput;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;
use Throwable;

/**
 * FormView Class
 *
 * @package Nodus\Packages\LivewireForms\Livewire
 *
 * @method submit(array $values)
 * @method submitCreate(array $values)
 * @method submitUpdate(array $values, Model $model)
 */
abstract class FormView extends Component
{
    use FormBuilder;
    use SupportsAdditionalViewParameters;

    /**
     * Post mode constants
     */
    public const POST_MODE_CREATE = 'create';
    public const POST_MODE_UPDATE = 'update';

    /**
     * Array of input values
     *
     * WARNING: Do not use this directly!
     * It's only public in order for livewire to work with it.
     * Consider using the related getter and setter instead.
     *
     * @var array
     */
    public array $values = [];

    /**
     * Array of registered inputs
     *
     * @var FormInput[]
     */
    private array $inputs = [];

    /**
     * Array of validation rules
     *
     * @var array
     */
    protected array $rules = [];

    /**
     * Path of the custom view to be used
     *
     * @var string|null
     */
    protected ?string $view = null;

    /**
     * Model class (if the underlying data object is a model)
     *
     * @var string|Model|null
     */
    public ?string $model = null;

    /**
     * Model ID (if the underlying data object is a model)
     *
     * @var int|null
     */
    public ?int $modelId = null;

    /**
     * Post handling mode (create or update)
     *
     * @var string
     */
    public string $postMode = self::POST_MODE_CREATE;

    /**
     * Custom translation prefix
     *
     * @var string|null
     */
    protected ?string $translationPrefix = null;

    /**
     * Initial render flag
     *
     * @var bool
     */
    protected bool $initialRender = false;

    /**
     * Label/Translation key for the save button
     *
     * @var string
     */
    protected string $saveButtonLabel = 'nodus.packages.livewire-forms::forms.general.save';

    /**
     * On component mount handler
     *
     * @param Model|array|null $modelOrArray
     * @param string|null      $postMode
     *
     * @throws Exception
     * @return void
     */
    public function mount($modelOrArray = null, string $postMode = null)
    {
        $this->initialRender = true;
        $this->postMode = $postMode ?? ($modelOrArray !== null ? self::POST_MODE_UPDATE : self::POST_MODE_CREATE);

        $this->loadValuesByModelOrArray($modelOrArray);
    }

    /**
     * Returns whether or not the form is in create mode
     *
     * @return bool
     */
    public function isCreateMode()
    {
        return $this->postMode === self::POST_MODE_CREATE;
    }

    /**
     * Returns whether or not the form is in update mode
     *
     * @return bool
     */
    public function isUpdateMode()
    {
        return $this->postMode === self::POST_MODE_UPDATE;
    }

    /**
     * Returns the underlaying model instance (but uses everytime an new query)
     *
     * @return Model|null
     */
    public function getModel()
    {
        // todo would caching here worth a try or is it not possible due to the nature of livewire?
        if ($this->modelId === null ||
            $this->model === null ||
            !is_a($this->model, Model::class, true)) {
            return null;
        }

        return $this->model::query()->findOrFail($this->modelId);
    }

    /**
     * Checks if the given value key exists using the "dot" notation
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasValue(string $key)
    {
        return Arr::has($this->values, $key);
    }

    /**
     * Returns the value for the given key using the "dot" notation
     *
     * @param string $key
     * @param null $default
     *
     * @return array|ArrayAccess|mixed
     */
    public function getValue(string $key, $default = null)
    {
        return Arr::get($this->values, $key, $default);
    }

    /**
     * Sets the value for the given key using the "dot" notation
     *
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public function setValue(string $key, $value)
    {
        return Arr::set($this->values, $key, $value);
    }

    /**
     * Sets an array of key-value pairs as values using the "dot" notation
     *
     * @param array $keyValueArray
     */
    public function setValues(array $keyValueArray)
    {
        foreach ($keyValueArray as $key => $value) {
            $this->setValue($key, $value);
        }
    }

    /**
     * Returns an array of all values
     *
     * @return array
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Loads the form values by the given model
     *
     * @param Model|array|null $modelOrArray
     *
     * @return void
     * @throws Exception
     */
    protected function loadValuesByModelOrArray($modelOrArray)
    {
        if ($modelOrArray === null) {
            $this->postMode = self::POST_MODE_CREATE;

            return;
        }

        if ($modelOrArray instanceof Model) {
            $this->loadValuesByModel($modelOrArray);

            return;
        }

        if (is_array($modelOrArray)) {
            $this->loadValuesByArray($modelOrArray);

            return;
        }

        throw new Exception('Invalid value for $modelOrArray');
    }

    /**
     * Loads the form values by the given model
     *
     * @param Model $model
     *
     * @return void
     */
    protected function loadValuesByModel(Model $model)
    {
        $this->model = get_class($model);

        // load relation collections as ID arrays for multiple selects
        foreach ($model->getRelations() as $key => $relation) {
            if (!$relation instanceof Collection) {
                continue;
            }

            $this->setValue($key, $relation->pluck('id')->toArray());
        }

        // We load all attributes because some inputs could be added later dynamically so we may need them.
        // Therefore we filter unessecarry values only later in the onSubmit method.
        $values = [];
        foreach ($model->getAttributes() as $key => $value) {
            $values[$key] = $model->getAttribute($key);
        }

        // Also we cannot use getAttributes here directly because on these values the casts aren't applied yet
        $this->setValues($values);

        if ($model->exists) {
            $this->modelId = $model->id;
        }
    }

    /**
     * Loads the form values by the given array
     *
     * @param array $array
     *
     * @return void
     */
    protected function loadValuesByArray(array $array)
    {
        $this->setValues($array);
    }

    /**
     * On input change handler
     *
     * @param $propertyName
     *
     * @throws ValidationException
     */
    public function updated($propertyName)
    {
        $this->prepareInputs();

        $this->validateOnly($propertyName, null, [], $this->getCustomValidationAttributes());
    }

    /**
     * Returns the array with custom validation attributes
     *
     * @return array
     */
    protected function getCustomValidationAttributes()
    {
        $customAttributes = [];

        foreach ($this->getRealInputs() as $input) {
            $customAttributes[ 'values.' . $input->getId() ] = $input->getLabel();
        }

        return $customAttributes;
    }

    /**
     * Filters the given array so that only keys that are represented in the form inputs are given back
     *
     * @param array $values
     *
     * @return array
     */
    protected function filterValues(array $values): array
    {
        $keys = [];
        foreach ($this->getRealInputs() as $input) {
            $keys[] = $input->getId();
        }

        $filteredValues = [];
        foreach ($keys as $key) {
            Arr::set($filteredValues, $key, Arr::get($values, $key));
        }

        return $filteredValues;
    }

    /**
     * On form submit handler
     *
     * @return string
     * @throws Exception
     */
    final public function onSubmit()
    {
        $this->prepareInputs();

        // Filter values
        $values = $this->filterValues($this->getValues());

        // Validations & mutators
        // todo the pre validation mutators are basically called twice due to the prepareForValidation method
        $values = $this->applyPreValidationMutators($values);
        $this->validate(null, [], $this->getCustomValidationAttributes());
        $values = $this->applyPostValidationMutators($values);

        // Custom post handling
        if (method_exists($this, 'submitCreate') && $this->isCreateMode()) {
            return $this->submitCreate($values);
        }

        if (method_exists($this, 'submitUpdate') && $this->isUpdateMode()) {
            $model = $this->model::query()->findOrFail($this->modelId);

            return $this->submitUpdate($values, $model);
        }

        if (method_exists($this, 'submit')) {
            return $this->submit($values);
        }

        // Default post handling
        return $this->defaultSubmit($values);
    }

    /**
     * Default model submit handling
     *
     * @param array $values
     *
     * @return string
     * @throws Exception
     */
    protected function defaultSubmit(array $values)
    {
        if (!is_a($this->model, Model::class, true)) {
            throw new Exception('You need to use either the custom post handling or use a model for initializing your form');
        }

        if ($this->isCreateMode()) {
            $this->model::query()->create($values);
        } else {
            $this->model::query()->findOrFail($this->modelId)->update($values);
        }

        return $this->returnResponse();
    }

    /**
     * Method which creates the return response
     *
     * @return RedirectResponse
     */
    protected function returnResponse()
    {
        return redirect()->back();
    }

    /**
     * Mutates the attributes in preparation for validation
     *
     * @param array $attributes
     *
     * @return array
     */
    public function prepareForValidation($attributes)
    {
        $attributes[ 'values' ] = $this->applyPreValidationMutators($attributes[ 'values' ]);

        return $attributes;
    }

    /**
     * Applies the pre validation mutator handlers if such are defined
     *
     * @param array $values
     *
     * @return array
     */
    private function applyPreValidationMutators(array $values)
    {
        foreach ($this->getRealInputs() as $input) {
            $key = $input->getId();
            $value = Arr::get($values, $key);

            if (is_string($value)) {
                $value = trim($value);
            }

            if (method_exists($input, 'preValidationMutator')) {
                $value = $input->preValidationMutator($value);
            }

            Arr::set($values, $key, $value);
        }

        return $values;
    }

    /**
     * Applies the post validation mutator handlers if such are defined
     *
     * @param array $values
     *
     * @return array
     */
    private function applyPostValidationMutators(array $values)
    {
        foreach ($this->getRealInputs() as $input) {
            $key = $input->getId();
            $value = Arr::get($values, $key);

            if (method_exists($input, 'postValidationMutator')) {
                $value = $input->postValidationMutator($value);
            }

            Arr::set($values, $key, $value);
        }

        return $values;
    }

    /**
     * Applies the pre render mutator handlers if such are defined
     */
    private function applyPreRenderMutators()
    {
        foreach ($this->getRealInputs() as $input) {
            $key = $input->getId();

            if (method_exists($input, 'preRenderMutator')) {
                $this->setValue($key, $input->preRenderMutator($this->getValue($key)));
            }
        }
    }

    /**
     * Overwrites the save button label
     *
     * @param string $label
     *
     * @return $this
     */
    public function setSaveButtonLabel(string $label)
    {
        $this->saveButtonLabel = $label;

        return $this;
    }

    /**
     * Returns the save button label
     *
     * @return string
     */
    public function getSaveButtonLabel()
    {
        return $this->saveButtonLabel;
    }

    /**
     * Sets the translation prefix
     *
     * @param string|null $prefix
     *
     * @return $this
     */
    protected function setTranslationPrefix(?string $prefix)
    {
        $this->translationPrefix = $prefix;

        return $this;
    }

    /**
     * Returns the translation prefix
     *
     * @return string
     */
    protected function getTranslationPrefix()
    {
        if ($this->translationPrefix === null) {
            return Str::plural(Str::snake(Str::afterLast($this->model, '\\'))) . '.fields';
        }

        return $this->translationPrefix;
    }

    /**
     * Generates a default translation string, based on model and column name
     *
     * @param string $lang Column name
     *
     * @return string
     */
    protected function getTranslationStringByModel(string $lang)
    {
        return $this->getTranslationPrefix() . '.' . $lang;
    }

    /**
     * Creates a FormInput instance by the given data and adds it to the form
     *
     * @param string      $class
     * @param string      $name
     * @param string|null $label
     *
     * @return FormInput
     */
    protected function addInput(string $class, string $name, ?string $label = null)
    {
        if ($label === null) {
            $label = $this->getTranslationStringByModel($name);
        }

        return $this->addFormInput(new $class($name, $label));
    }

    /**
     * Adds an given FormInput instance to the form
     *
     * @param FormInput $input
     *
     * @return FormInput
     */
    private function addFormInput(FormInput $input)
    {
        $this->inputs[ $input->getId() ] = $input;

        return $input;
    }

    /**
     * Method which should define all form inputs in the derived classes
     *
     * @return void
     */
    abstract public function inputs();

    /**
     * Handles some preperation stuff for initializing the registered inputs
     */
    protected function prepareInputs()
    {
        $this->inputs();

        $model = $this->getModel();

        foreach ($this->getRealInputs() as $input) {
            $key = $input->getId();

            if (!$this->hasValue($key)) {
                $this->setValue($key, null);
            }

            if (in_array(SupportsValidations::class, class_uses($input))) {
                $this->rules[$input->getViewId()] = $input->rewriteValidationRules($model);
            } else {
                $this->rules[$input->getViewId()] = [];
            }

            if (in_array(SupportsDefaultValue::class, class_uses($input))) {
                $this->setValue($key, $input->getValue($this->getValue($key)));
            }
        }

        $this->applyPreRenderMutators();
    }

    /**
     * Returns the array with all registered real inputs (excludes html)
     *
     * @return array
     */
    public function getRealInputs()
    {
        $inputs = [];

        foreach ($this->inputs as $input) {
            if ($input instanceof FormBuilder\Html) {
                continue;
            }

            $inputs[] = $input;
        }

        return $inputs;
    }

    /**
     * Returns the array with all registered inputs
     *
     * @return array
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Returns a specific FormInput by the given identifier
     *
     * @param string $identifier
     *
     * @return FormInput|null
     */
    public function getInput(string $identifier)
    {
        return $this->inputs[ $identifier ] ?? null;
    }

    /**
     * Renders the form view
     *
     * @return string
     * @throws Throwable
     */
    public function render()
    {
        $this->prepareInputs();

        if ($this->view === null) {
            $this->view = 'nodus.packages.livewire-forms::livewire.' . config('livewire-forms.theme') . '.formview';
        }

        return view($this->view, ['initialRender' => $this->initialRender]);
    }
}
