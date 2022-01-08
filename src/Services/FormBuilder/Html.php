<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;

class Html extends FormInput
{
    use SupportsSize;

    /**
     * Html constructor.
     *
     * @param string|null $id
     * @param string      $content
     */
    public function __construct(?string $id, string $content)
    {
        parent::__construct($id, $content);

        $this->setSize(4);
    }
}
