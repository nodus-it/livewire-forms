<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Livewire\TemporaryUploadedFile;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsArrayValidations;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
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
    use SupportsArrayValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsDisabling;

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
     * @return $this
     * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file#htmlattrdefaccept
     */
    public function setAcceptFormats(string $acceptFormats): static
    {
        $this->acceptFormats = $acceptFormats;

        return $this;
    }

    /**
     * Returns the accepted file formats
     *
     * @return string|null
     */
    public function getAcceptFormats(): ?string
    {
        return $this->acceptFormats;
    }

    /**
     * Pre render mutator handler
     *
     * @param TemporaryUploadedFile|TemporaryUploadedFile[]|array|string|null $value
     *
     * @return TemporaryUploadedFile|null|TemporaryUploadedFile[]
     */
    public function preRenderMutator($value)
    {
        if ($this->getMultiple() === true) {
            if (!is_array($value)) {
                return [];
            }

            foreach ($value as $key => $file) {
                if (!$file instanceof TemporaryUploadedFile) {
                    $value[$key] = null;
                }
            }

            return array_filter($value);
        }

        if (!$value instanceof TemporaryUploadedFile) {
            return null;
        }

        return $value;
    }
}
