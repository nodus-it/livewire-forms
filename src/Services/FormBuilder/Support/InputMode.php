<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder\Support;

/**
 * HTML input modes enum
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/inputmode
 */
enum InputMode: string
{
    case None = 'none';
    case Text = 'text';
    case Decimal = 'decimal';
    case Numeric = 'numeric';
    case Tel = 'tel';
    case Search = 'search';
    case Email = 'email';
    case Url = 'url';
}
