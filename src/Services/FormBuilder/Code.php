<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Code editor input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Code extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;

    /**
     * Syntax Hightlight mode
     *
     * @var string|null
     */
    protected ?string $mode = null;

    /**
     * Sets the syntax hightlight mode
     *
     * @param string $mode
     *
     * @return $this
     */
    public function setMode(string $mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Returns the syntax highlight mode
     *
     * @return string|null
     */
    public function getMode()
    {
        return $this->mode;
    }
}
