<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsPlaceholder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Textarea input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Textarea extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsPlaceholder;

    /**
     * Rows count
     * 
     * @var int|null 
     */
    protected ?int $rows = null;

    /**
     * Sets the display height of the textarea in rows
     * 
     * @param int $rows
     *                 
     * @return $this
     */
    public function setRows(int $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * Returns the display height of the textarea in rows
     * 
     * @return int|null
     */
    public function getRows(): ?int
    {
        return $this->rows;
    }
}
