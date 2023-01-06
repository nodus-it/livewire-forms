<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsHint;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsInputMode;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsPlaceholder;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;
use NumberFormatter;

/**
 * Decimal input class
 *
 * @package Nodus\Packages\LivewireForms\Services\FormBuilder
 */
class Decimal extends FormInput
{
    use SupportsDefaultValue;
    use SupportsValidations;
    use SupportsSize;
    use SupportsHint;
    use SupportsPlaceholder;
    use SupportsInputMode;

    /**
     * Number of decimals to be shown of the decimal value
     *
     * @var int
     */
    protected int $decimals = 2;

    /**
     * The unit to be shown after the decimal value
     *
     * @var string|null
     */
    protected ?string $unit = 'EUR';

    /**
     * Decimal constructor.
     *
     * @param string      $name
     * @param string|null $label
     */
    public function __construct(string $name, ?string $label = null)
    {
        $this->setDefaultValue(0.0);

        parent::__construct($name, $label);
    }

    /**
     * Set the number of decimals to be shown of the decimal value
     *
     * @param int $decimals
     *
     * @return $this
     */
    public function setDecimals(int $decimals): static
    {
        $this->decimals = $decimals;

        return $this;
    }

    /**
     * Returns the number of decimals to be shown of the decimal value
     *
     * @return int
     */
    public function getDecimals(): int
    {
        return $this->decimals;
    }

    /**
     * Set the unit to be shown after the decimal value
     *
     * @param string|null $unit
     *
     * @return $this
     */
    public function setUnit(?string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Returns the unit code to be used after the decimal value
     *
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * Returns a currency NumberFormatter instance for the given locale
     *
     * @param string $locale
     *
     * @return false|NumberFormatter
     */
    public function getNumberFormatter(string $locale = 'de_DE'): bool|NumberFormatter
    {
        $format = NumberFormatter::create($locale, NumberFormatter::CURRENCY);

        $format->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $this->getDecimals());
        $format->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $this->getDecimals());

        return $format;
    }

    /**
     * Pre render mutator handler
     *
     * @param $value
     *
     * @return string|null
     */
    public function preRenderMutator($value): ?string
    {
        if (empty($value)) {
            $value = 0;
        }

        return $this->getNumberFormatter()->formatCurrency(
            static::parseValue($value),
            $this->getUnit()
        );
    }

    /**
     * Pre validation mutator handler
     *
     * @param string $decimal
     *
     * @return float
     */
    public function preValidationMutator(string $decimal): float
    {
        return static::parseValue($decimal);
    }

    /**
     * Parses a formatted decimal input string
     *
     * @param $value
     *
     * @return float
     */
    public static function parseValue($value): float
    {
        if (is_float($value)) {
            return $value;
        }

        return floatval(str_replace(',', '.', preg_replace('/[^0-9,-]+/', '', $value)));
    }
}
