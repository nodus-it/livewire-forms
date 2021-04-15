<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;

class Html extends FormInput
{
    use SupportsSize;

    /**
     * Html constructor.
     *
     * @param string      $content
     * @param string|null $id
     */
    public function __construct(string $content, ?string $id = null)
    {
        if ($id === null) {
            $id = md5($content);
        }

        parent::__construct($content, $id);

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
