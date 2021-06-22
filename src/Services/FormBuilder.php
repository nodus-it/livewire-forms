<?php

namespace Nodus\Packages\LivewireForms\Services;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Checkbox;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Code;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Color;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Date;
use Nodus\Packages\LivewireForms\Services\FormBuilder\DateTime;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Decimal;
use Nodus\Packages\LivewireForms\Services\FormBuilder\File;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Hidden;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Html;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Number;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Password;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Radio;
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
    public function addText(string $name, string $label = null)
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
    public function addColor(string $name, string $label = null)
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
    public function addPassword(string $name, string $label = null)
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
    public function addFile(string $name, string $label = null)
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
    public function addNumber(string $name, string $label = null)
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
    public function addTextarea(string $name, string $label = null)
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
    public function addDate(string $name, string $label = null)
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
    public function addTime(string $name, string $label = null)
    {
        return $this->addInput(Time::class, $name, $label);
    }

    /**
     * Adds an date time input
     *
     * @param string      $name
     * @param string|null $label
     *
     * @return Date
     */
    public function addDateTime(string $name, string $label = null)
    {
        return $this->addInput(DateTime::class, $name, $label);
    }

    /**
     * Adds an decimal input
     *
     * @param string      $name
     * @param string|null $label
     *
     * @return Decimal
     */
    public function addDecimal(string $name, string $label = null)
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
    public function addSelect(string $name, string $label = null)
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
    public function addCheckbox(string $name, string $label = null)
    {
        return $this->addInput(Checkbox::class, $name, $label);
    }

    /**
     * Adds an radio input group
     *
     * @param string      $name
     * @param string|null $label
     *
     * @return Radio
     */
    public function addRadio(string $name, string $label = null)
    {
        return $this->addInput(Radio::class, $name, $label);
    }

    /**
     * Adds an rich textarea input
     *
     * @param string      $name
     * @param string|null $label
     *
     * @return RichTextarea
     */
    public function addRichTextarea(string $name, string $label = null)
    {
        return $this->addInput(RichTextarea::class, $name, $label);
    }

    /**
     * Adds an code editor input
     *
     * @param string      $name
     * @param string|null $label
     *
     * @return Code
     */
    public function addCode(string $name, string $label = null)
    {
        return $this->addInput(Code::class, $name, $label);
    }

    /**
     * Adds an hidden input
     *
     * @param string $name
     * @param string $value
     *
     * @return Hidden
     */
    public function addHidden(string $name, string $value)
    {
        $input = new Hidden($name, $value);

        $this->inputs[ $input->getId() ] = $input;

        return $input;
    }

    /**
     * Adds an Section delimiter with headline
     *
     * @param string      $label
     * @param string|null $id
     *
     * @return Html
     */
    public function addSection(string $label, ?string $id = null)
    {
        return $this->addHtml('<h3>' . trans($label) . '</h3><hr/>', $id);
    }

    /**
     * Adds an Html block
     *
     * @param string      $content
     * @param string|null $id
     *
     * @return Html
     */
    public function addHtml(string $content, ?string $id = null)
    {
        if ($id == null) {
            $id = md5($content);
        }

        return $this->addInput(Html::class, $id, $content);
    }
}
