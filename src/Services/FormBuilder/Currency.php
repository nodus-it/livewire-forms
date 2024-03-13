<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\Currency as CurrencyEnum;

/**
 * Currency input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Currency extends Decimal
{
    /**
     * The unit to be shown after the decimal value
     *
     * @var string|CurrencyEnum|null
     */
    protected CurrencyEnum|string|null $unit = CurrencyEnum::Euro;
}
