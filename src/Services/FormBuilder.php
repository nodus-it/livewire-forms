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
        /**
         * Adds an text input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Text
         */
        protected function addText(string $name, string $label = null)
        {
            return $this->addInput(Text::class, $name, $label);
        }

        /**
         * Adds an color input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Color
         */
        protected function addColor(string $name, string $label = null)
        {
            return $this->addInput(Color::class, $name, $label);
        }

        /**
         * Adds an password input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Password
         */
        protected function addPassword(string $name, string $label = null)
        {
            return $this->addInput(Password::class, $name, $label);
        }

        /**
         * Adds an file input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return File
         */
        protected function addFile(string $name, string $label = null)
        {
            return $this->addInput(File::class, $name, $label);
        }

        /**
         * Adds an number input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Number
         */
        protected function addNumber(string $name, string $label = null)
        {
            return $this->addInput(Number::class, $name, $label);
        }

        /**
         * Adds an textarea input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Textarea
         */
        protected function addTextarea(string $name, string $label = null)
        {
            return $this->addInput(Textarea::class, $name, $label);
        }

        /**
         * Adds an date input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Date
         */
        protected function addDate(string $name, string $label = null)
        {
            return $this->addInput(Date::class, $name, $label);
        }

        /**
         * Adds an time input
         *
         * @param string      $name
         * @param string|null $label
         *
         * @return Time
         */
        protected function addTime(string $name, string $label = null)
        {
            return $this->addInput(Time::class, $name, $label);
        }

        /**
         * Adds an decimal input
         *
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
         * Adds an select input
         *
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
         * Adds an checkbox input
         *
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

        /**
         * Adds an hidden input
         *
         * @param string $name
         * @param string $value
         *
         * @return Hidden
         */
        protected function addHidden(string $name, string $value)
        {
            $input = new Hidden($name, $value);

            $this->inputs[ $input->getId() ] = $input;

            return $input;
        }
    }
