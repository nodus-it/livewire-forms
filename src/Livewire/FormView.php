<?php

namespace Nodus\Packages\LivewireForms\Livewire;

use ArrayAccess;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
use Livewire\Component;
use Livewire\Livewire;
use Nodus\Packages\LivewireCore\Services\SupportsTranslationsByModel;
use Nodus\Packages\LivewireCore\SupportsAdditionalViewParameters;
use Nodus\Packages\LivewireForms\Services\FormBuilder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\FormInput;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsArrayValidations;
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
    use SupportsTranslationsByModel;
    use SupportsAdditionalViewParameters;

    /**
     * Post mode constants
     */
    public const POST_MODE_CREATE = 'create';
    public const POST_MODE_UPDATE = 'update';

    /**
     * ID of the form
     *
     * @var string
     */
    public string $formId;

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
     * Custom validation messages (prefixed with the field name e.g "first_name.required")
     *
     * @var array
     */
    protected array $messages = [];

    /**
     * Path of the custom view to be used
     *
     * @var string|null
     */
    protected ?string $view = null;

    /**
     * Model class (if the underlying data object is a model)
     *
     * @var class-string<Model>|null
     */
    public ?string $model = null;

    /**
     * Model ID (if the underlying data object is a model)
     *
     * @var int|null
     */
    public ?int $modelId = null;

    /**
     * Model instance cache
     *
     * @var Model|null
     */
    protected ?Model $modelInstance = null;

    /**
     * Post handling mode (create or update)
     *
     * @var string
     */
    public string $postMode = self::POST_MODE_CREATE;

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
    public string $saveButtonLabel = 'nodus.packages.livewire-forms::forms.general.save';

    /**
     * Save button CSS classes
     *
     * @var string
     */
    public string $saveButtonClasses = 'btn btn-primary';

    /**
     * Save button icon CSS classes (null = no icon)
     *
     * @var string|null
     */
    public ?string $saveButtonIconClasses = null;

    /**
     * On component mount handler
     *
     * @param Model|array|null $modelOrArray
     * @param string|null      $postMode
     *
     * @throws Exception
     * @return void
     */
    public function mount(Model|array|null $modelOrArray = null, string $postMode = null): void
    {
        $this->formId = $this->generateFormId();
        $this->initialRender = true;
        $this->postMode = $postMode ?? ($modelOrArray !== null ? self::POST_MODE_UPDATE : self::POST_MODE_CREATE);

        $this->loadValuesByModelOrArray($modelOrArray);
    }

    /**
     * Generates a new form ID
     *
     * @return string
     */
    protected function generateFormId(): string
    {
        return 'form-' . Str::random();
    }

    /**
     * Returns the form ID
     *
     * @return string
     */
    public function getFormId(): string
    {
        return $this->formId;
    }

    /**
     * Returns whether the form is in create mode
     *
     * @return bool
     */
    public function isCreateMode(): bool
    {
        return $this->postMode === self::POST_MODE_CREATE;
    }

    /**
     * Returns whether the form is in update mode
     *
     * @return bool
     */
    public function isUpdateMode(): bool
    {
        return $this->postMode === self::POST_MODE_UPDATE;
    }

    /**
     * Returns the underlying model instance (but uses everytime a new query)
     *
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        if ($this->modelId === null ||
            $this->model === null ||
            !is_a($this->model, Model::class, true)) {
            return null;
        }

        if ($this->modelInstance !== null) {
            return $this->modelInstance;
        }

        $this->modelInstance = $this->model::query()->findOrFail($this->modelId);

        return $this->modelInstance;
    }

    /**
     * Checks if the given value key exists using the "dot" notation
     *
     * @param string $key
     *
     * @return bool
     */
    public function hasValue(string $key): bool
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
    public function setValue(string $key, mixed $value): array
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
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Loads the form values by the given model
     *
     * @param Model|array|null $modelOrArray
     *
     * @throws Exception
     * @return void
     */
    protected function loadValuesByModelOrArray(Model|array|null $modelOrArray): void
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
    protected function loadValuesByModel(Model $model): void
    {
        $this->model = get_class($model);

        // load relation collections as ID arrays for multiple selects
        foreach ($model->getRelations() as $key => $relation) {
            if (!$relation instanceof Collection) {
                continue;
            }

            $this->setValue($key, $relation->pluck('id')->toArray());
        }

        // We load all attributes because some inputs could be added later dynamically, so we may need them.
        // Therefore, we filter unnecessary values only later in the onSubmit method.
        $values = [];
        foreach ($model->getAttributes() as $key => $value) {
            $values[$key] = $model->getAttribute($key);
        }

        // Also, we cannot use getAttributes here directly because on these values the casts aren't applied yet
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
    protected function loadValuesByArray(array $array): void
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

        // In case we have added array validations, we check them here separately
        if (isset($this->rules[$propertyName . '.*'])) {
            $this->validateOnly($propertyName . '.*', null, [], $this->getCustomValidationAttributes());
        }
    }

    /**
     * Returns the custom messages and add the right prefix in case it isn't already added
     *
     * @return array
     */
    protected function getMessages(): array
    {
        $messages = parent::getMessages();

        foreach ($messages as $key => $message) {
            if (!Str::startsWith($key, 'values.')) {
                $messages[ 'values.' . $key ] = $message;
                unset($messages[ $key ]);
            }
        }

        return $messages;
    }

    /**
     * Returns the array with custom validation attributes
     *
     * @return array
     */
    protected function getCustomValidationAttributes(): array
    {
        $customAttributes = [];

        foreach ($this->getRealInputs() as $input) {
            $customAttributes[ 'values.' . $input->getId() ] = $input->getLabel();

            // Define for the array validations for each item in the value a custom attribute label
            if (in_array(FormBuilder\Traits\SupportsArrayValidations::class, class_uses($input))) {
                $value = $this->getValue($input->getId());

                if (!is_array($value)) {
                    continue;
                }

                foreach (range(0, count($value)) as $i) {
                    $customAttributes['values.' . $input->getId() . '.' . $i] = $input->getLabel() . ' #' . ($i + 1);
                }
            }
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
     * Applies the mutators and validates the form values
     *
     * @return array
     */
    protected function getValidatedValues(): array
    {
        // The pre validation mutators are already called in the prepareForValidation method (see validate call)
        return $this->applyPostValidationMutators(
            $this->validate(null, [], $this->getCustomValidationAttributes())['values']
        );
    }

    /**
     * On form submit handler
     *
     * @throws Exception
     * @return RedirectResponse
     */
    final public function onSubmit()
    {
        $this->prepareInputs();

        $values = $this->getValidatedValues();

        $this->registerSubmitValidationExceptionHandler();

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
     * @throws Exception
     * @return RedirectResponse
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
     * Registers the custom submit validation exception handler
     *
     * @return void
     */
    protected function registerSubmitValidationExceptionHandler(): void
    {
        Livewire::listen('failed-validation', function (Validator $validator) {
            $this->submitValidationExceptionHandler($validator);
        });
    }

    /**
     * Custom submit validation exception handler
     *
     * @param Validator $validator
     *
     * @codeCoverageIgnore
     */
    protected function submitValidationExceptionHandler(Validator $validator)
    {
        // overwrite
    }

    /**
     * Mutates the attributes in preparation for validation
     *
     * @param array $attributes
     *
     * @return array
     */
    public function prepareForValidation($attributes): array
    {
        $attributes[ 'values' ] = $this->applyPreValidationMutators(
            $this->filterValues($attributes[ 'values' ])
        );

        return $attributes;
    }

    /**
     * Applies the pre validation mutator handlers if such are defined
     *
     * @param array $values
     *
     * @return array
     */
    private function applyPreValidationMutators(array $values): array
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
    private function applyPostValidationMutators(array $values): array
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
    public function setSaveButtonLabel(string $label): static
    {
        $this->saveButtonLabel = $label;

        return $this;
    }

    /**
     * Returns the save button label
     *
     * @return string
     */
    public function getSaveButtonLabel(): string
    {
        return $this->saveButtonLabel;
    }

    /**
     * Adds the given classes to the existing save button CSS classes
     *
     * @param string $classes
     *
     * @return $this
     */
    public function addSaveButtonClasses(string $classes): static
    {
        $this->saveButtonClasses .= ' ' . $classes;

        return $this;
    }

    /**
     * Overwrites the save button CSS classes
     *
     * @param string $classes
     *
     * @return $this
     */
    public function setSaveButtonClasses(string $classes): static
    {
        $this->saveButtonClasses = $classes;

        return $this;
    }

    /**
     * Returns the save button CSS classes
     *
     * @return string
     */
    public function getSaveButtonClasses(): string
    {
        return $this->saveButtonClasses;
    }

    /**
     * Overwrites the save button icon CSS classes
     *
     * @param string|null $classes
     *
     * @return $this
     */
    public function setSaveButtonIconClasses(?string $classes): static
    {
        $this->saveButtonIconClasses = $classes;

        return $this;
    }

    /**
     * Returns the save button icon CSS classes
     *
     * @return string|null
     */
    public function getSaveButtonIconClasses(): ?string
    {
        return $this->saveButtonIconClasses;
    }

    /**
     * Creates a FormInput instance by the given data and adds it to the form
     *
     * @param string                                  $class
     * @param string                                  $name
     * @param string|null                             $label
     *
     * @return FormInput
     *
     * @psalm-template RealInstanceType of object
     * @psalm-param    class-string<RealInstanceType> $class
     * @psalm-return   RealInstanceType
     */
    protected function addInput(string $class, string $name, ?string $label = null)
    {
        if ($label === null) {
            $label = $this->getTranslationStringByModel('fields.' . $name);
        }

        return $this->addFormInput(new $class($name, $label));
    }

    /**
     * Adds a given FormInput instance to the form
     *
     * @param FormInput $input
     *
     * @return FormInput
     */
    private function addFormInput(FormInput $input): FormInput
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
     * Handles some preparation stuff for initializing the registered inputs
     *
     * @return void
     */
    protected function prepareInputs(): void
    {
        $this->inputs();

        $model = $this->getModel();

        foreach ($this->getRealInputs() as $input) {
            $key = $input->getId();

            if (!$this->hasValue($key)) {
                $this->setValue($key, null);
            }

            $inputTraits = class_uses($input);

            if (in_array(SupportsValidations::class, $inputTraits)) {
                $this->rules[$input->getViewId()] = $input->rewriteValidationRules($model);
            } else {
                $this->rules[$input->getViewId()] = [];
            }

            if (in_array(SupportsArrayValidations::class, $inputTraits)) {
                $this->rules[$input->getViewId() . '.*'] = $input->getArrayValidations();
            }

            if (in_array(SupportsDefaultValue::class, $inputTraits)) {
                $this->setValue($key, $input->getValue($this->getValue($key)));
            }
        }

        $this->applyPreRenderMutators();
    }

    /**
     * Returns the array with all registered real inputs (excludes html)
     *
     * @return array|FormInput[]
     */
    public function getRealInputs(): array
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
    public function getInputs(): array
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
    public function getInput(string $identifier): ?FormInput
    {
        return $this->inputs[ $identifier ] ?? null;
    }

    /**
     * Renders the form view
     *
     * @throws Throwable
     * @return Factory|View
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
