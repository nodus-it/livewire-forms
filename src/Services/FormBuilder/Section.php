<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

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
     * @param string      $label
     * @param string|null $id
     */
    public function __construct(string $label, ?string $id = null)
    {
        if ($id === null) {
            $id = $label;
        }

        parent::__construct($id, $label);

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
}
