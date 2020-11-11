<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Illuminate\Support\Carbon;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

/**
 * Rich textarea editor (WYSIWYG) input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class RichTextarea extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
}
