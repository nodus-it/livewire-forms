<?php

    namespace Nodus\Packages\LivewireForms\Services;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Color;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Decimal;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Number;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Password;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\RichTextarea;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Select;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Text;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Textarea;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Time;

    /**
     * FormBuilder Trait
     *
     * @package Nodus\Packages\LivewireDatatables\Services
     */
    trait FormBuilder
    {
        protected function addText(string $name, string $label = null)
        {
            return $this->addInput(Text::class, $name, $label);
        }

        protected function addColor(string $name, string $label = null)
        {
            return $this->addInput(Color::class, $name, $label);
        }

        protected function addPassword(string $name, string $label = null)
        {
            return $this->addInput(Password::class, $name, $label);
        }

        protected function addFile(string $name, string $label = null)
        {
            return $this->addInput(File::class, $name, $label);
        }

        protected function addNumber(string $name, string $label = null)
        {
            return $this->addInput(Number::class, $name, $label);
        }

        protected function addTextarea(string $name, string $label = null)
        {
            return $this->addInput(Textarea::class, $name, $label);
        }

        protected function addDate(string $name, string $label = null)
        {
            return $this->addInput(Date::class, $name, $label);
        }

        protected function addTime(string $name, string $label = null)
        {
            return $this->addInput(Time::class, $name, $label);
        }

        /**
         * @param string      $name
         * @param string|null $label
         *
         * @return Decimal
         */
        protected function addDecimal(string $name, string $label = null)
        {
            return $this->addInput(Decimal::class, $name, $label);
        }

        /**
         * @param string      $name
         * @param string|null $label
         *
         * @return Select
         */
        protected function addSelect(string $name, string $label = null)
        {
            return $this->addInput(Select::class, $name, $label);
        }

        /**
         * @param string      $name
         * @param string|null $label
         *
         * @return Checkbox
         */
        protected function addCheckbox(string $name, string $label = null)
        {
            return $this->addInput(Checkbox::class, $name, $label);
        }

        /**
         * Adds an rich textarea input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return mixed
         */
        protected function addRichTextarea(string $name, string $label = null)
        {
            return $this->addInput(RichTextarea::class, $name, $label);
        }

        protected function addHidden(string $name, string $value)
        {
            $input = new Hidden($name, $value);

            $this->inputs[ $input->getId() ] = $input;

            return $input;
        }

    }
