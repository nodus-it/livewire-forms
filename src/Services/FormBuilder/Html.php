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
}
