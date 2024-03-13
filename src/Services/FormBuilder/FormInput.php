<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Str;

/**
 * Form input base class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
abstract class FormInput
{
    /**
     * Input label (translation string)
     *
     * @var string|null
     */
    protected ?string $label;

    /**
     * Input name
     *
     * @var string
     */
    protected string $name;

    /**
     * Input identifier
     *
     * @var string
     */
    protected string $id;

    /**
     * HTML Flag for Label
     *
     * @var bool
     */
    private bool $htmlLabel = false;

    /**
     * FormElement constructor.
     *
     * @param string $name
     * @param string|null $label
     */
    public function __construct(string $name, ?string $label = null)
    {
        $this->label = $label ?? $name;
        $this->name = $name;
        $this->id = $name;
    }

    /**
     * Creates a new form input instance
     *
     * @param string      $name
     * @param null|string $label
     *
     * @return FormInput|static
     */
    public static function create(string $name, ?string $label = null): static
    {
        return new static($name, $label);
    }

    /**
     * To string function
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Returns the name of the related blade view
     *
     * @return string
     */
    public function getViewName(): string
    {
        $view = 'nodus.packages.livewire-forms::livewire.' . config('livewire-forms.theme') . '.components.types.' . $this->getType();

        if (!view()->exists($view)) {
            return 'nodus.packages.livewire-forms::livewire.' . config('livewire-forms.theme') . '.components.input';
        }

        return $view;
    }

    /**
     * Renders the form input
     *
     * @param bool $initialRender
     *
     * @return string
     */
    public function render(bool $initialRender = false): string
    {
        return view($this->getViewName())
            ->with('input', $this)
            ->with('initialRender', $initialRender)
            ->render();
    }

    /**
     * Returns the input type
     *
     * @return string
     */
    public function getType(): string
    {
        return strtolower(class_basename(static::class));
    }

    /**
     * Returns the name of the input
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the label of the input
     *
     * @return string
     */
    public function getLabel(): string
    {
        return trans($this->label);
    }

    /**
     * Activates HTML for the label
     *
     * @return $this
     */
    public function setLabelHtml(): static
    {
        $this->htmlLabel = true;

        return $this;
    }

    /**
     * Returns HTML flag for label
     *
     * @return bool
     */
    public function hasHtmlLabel(): bool
    {
        return $this->htmlLabel;
    }

    /**
     * Returns the identifier of the input
     *
     * @param bool $escape
     *
     * @return string
     */
    public function getId(bool $escape = false): string
    {
        if ($escape === true) {
            return str_replace('.', '__', $this->id);
        }

        return $this->id;
    }

    /**
     * Returns the view identifier of the input
     *
     * @return string
     */
    public function getViewId(): string
    {
        return 'values.' . $this->getId();
    }

    /**
     * Returns an array with the keys of the error message bag
     *
     * @return array
     */
    public function getErrorKeys(): array
    {
        return [
            $this->getViewId(),
            $this->getViewId() . '.*',
        ];
    }

    /**
     * Returns if the current input support a given feature (traits)
     *
     * @param string $feature
     *
     * @return bool
     */
    public static function supports(string $feature): bool
    {
        $traits = collect(class_uses(static::class))
            ->map(fn ($value) => Str::of($value)
                ->classBasename()
                ->lower()
                ->replaceFirst('supports', '')
                ->toString()
            )->toArray();

        return in_array(Str::lower($feature), $traits);
    }
}
