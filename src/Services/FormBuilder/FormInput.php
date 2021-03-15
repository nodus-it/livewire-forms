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
         * FormElement constructor.
         *
         * @param string      $name
         * @param string|null $label
         */
        public function __construct(string $name, ?string $label = null)
        {
            $this->label = $label ?? $name;
            $this->name = $name;
            $this->id = $name;
        }

        /**
         * Creates an new form input instance
         *
         * @param null|string $label
         * @param string      $name
         *
         * @return FormInput|static
         */
        public static function create(string $name, ?string $label = null)
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
        public function getViewName()
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
         * @return  string
         */
        public function render(bool $initialRender = false)
        {
            return view($this->getViewName(), ['input' => $this, 'initialRender' => $initialRender])->render();
        }

        /**
         * Returns the input type
         *
         * @return string
         */
        public function getType()
        {
            return strtolower(class_basename(static::class));
        }

        /**
         * Returns the name of the input
         *
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * Returns the label of the input
         *
         * @return string
         */
        public function getLabel()
        {
            return trans($this->label);
        }

        /**
         * Returns the identifier of the input
         *
         * @param bool $escape
         *
         * @return string
         */
        public function getId(bool $escape = false)
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
        public function getViewId()
        {
            return 'values.' . $this->getId();
        }

        public static function supports(string $feature)
        {
            // todo maybe use static cache
            $traits = collect(class_uses(static::class))->map(
                function ($value) {
                    return (string)(Str::of($value)->classBasename()->lower()->replaceFirst('supports',''));
                }
            )->toArray();

            return in_array(Str::lower($feature), $traits);
        }
    }
