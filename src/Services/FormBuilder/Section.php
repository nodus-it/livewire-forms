<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireDatatables\Services\Column;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;

class Section extends FormInput
{
    use SupportsSize;

    /**
     * Flag for enabling/disabling html output
     *
     * @var bool
     */
    protected bool $html = false;

    /**
     * Section constructor.
     *
     * @param string $label
     */
    public function __construct(string $label)
    {
        parent::__construct($label, $label);

        $this->setSize(4);
    }

    /**
     * Sets the html flag
     *
     * @param bool $html Allow html
     *
     * @return Section
     */
    public function enableHtml(bool $html = true)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Returns the html flag
     *
     * @return bool
     */
    public function isHtmlEnabled()
    {
        return $this->html;
    }

    /**
     * Returns the label of the input
     *
     * @return string
     */
    public function getLabel()
    {
        if ($this->isHtmlEnabled()) {
            return parent::getLabel();
        }

        return e(parent::getLabel());
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
        return view('section', ['input' => $this, 'initialRender' => $initialRender])->render();
    }
}
