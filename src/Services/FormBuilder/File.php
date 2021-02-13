<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Livewire\TemporaryUploadedFile;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * File input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class File extends FormInput
{
    use SupportsMultiple;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;

    /**
     * Accepted file formats
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#htmlattrdefaccept
     *
     * @var string|null
     */
    protected ?string $acceptFormats = null;

    /**
     * Defines the accepted file formats
     *
     * @param string $acceptFormats
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#htmlattrdefaccept
     *
     * @return $this
     */
    public function setAcceptFormats(string $acceptFormats)
    {
        $this->acceptFormats = $acceptFormats;

        return $this;
    }

    /**
     * Returns the accepted file formats
     *
     * @return bool
     */
    public function getAcceptFormats()
    {
        return $this->acceptFormats;
    }

    /**
     * Pre render mutator handler
     *
     * @param TemporaryUploadedFile|string|null $value
     *
     * @return string|null
     */
    public function preRenderMutator($value)
    {
        if (!$value instanceof TemporaryUploadedFile) {
            return null;
        }

        return $value;
    }
}
