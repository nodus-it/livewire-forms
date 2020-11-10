<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

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
}
