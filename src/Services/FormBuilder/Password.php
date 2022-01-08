<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsPlaceholder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Password input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Password extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsPlaceholder;

    /**
     * Secure mode flag
     *
     * @var bool
     */
    protected bool $secure = false;

    /**
     * Sets the secure mode for the password input
     *
     * @param bool $secure
     *
     * @return $this
     */
    public function setSecure(bool $secure = true): self
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * Pre render mutator handler
     *
     * @param string|null $password
     *
     * @return string|null
     */
    public function preRenderMutator($password)
    {
        if (empty($password)) {
            return null;
        }

        if ($this->secure === true) {
            return null;
        }

        return $password;
    }
}
