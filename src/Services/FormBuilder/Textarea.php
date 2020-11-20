<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsMultiple;
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
    }
