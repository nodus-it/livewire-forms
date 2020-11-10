<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

    /**
     * Number input class
     *
     * @package Nodus\Packages\LivewireForms\Services\FormBuilder
     */
    class Number extends FormInput
    {
        use SupportsDefaultValue;
        use SupportsValidations;
        use SupportsSize;

        // todo min, max, step support
    }
