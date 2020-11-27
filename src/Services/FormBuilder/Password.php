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
    }
