<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Carbon;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMinMax;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Time input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Time extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsMinMax;
    use SupportsDisabling;

    /**
     * Post validation mutator handler
     *
     * @param string|null $time
     *
     * @return Carbon|null
     */
    public function postValidationMutator(?string $time): ?Carbon
    {
        if (empty($time)) {
            return null;
        }

        return Carbon::parse($time);
    }

    /**
     * Pre render mutator handler
     *
     * @param $time
     *
     * @return string|null
     */
    public function preRenderMutator($time): ?string
    {
        if (empty($time)) {
            return null;
        }

        return Carbon::parse($time)->format('H:i:s');
    }
}
