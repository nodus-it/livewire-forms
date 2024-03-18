<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
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
     * Syntax Highlight mode
     *
     * @var string|null
     */
    protected ?string $mode = null;

    /**
     * Sets the syntax highlight mode
     *
     * @param string $mode
     *
     * @return $this
     */
    public function setMode(string $mode): static
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Returns the syntax highlight mode
     *
     * @return string|null
     */
    public function getMode(): ?string
    {
        return $this->mode;
    }
}
