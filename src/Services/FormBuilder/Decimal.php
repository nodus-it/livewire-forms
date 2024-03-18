<?php

namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\Currency;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Support\InputMode;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDisabling;
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
    use SupportsDisabling;

    /**
     * Number of decimals to be shown of the decimal value
     *
     * @var int
     */
    protected int $decimals = 2;

    /**
     * The unit to be shown after the decimal value
     *
     * @var string|Currency|null
     */
    protected Currency|string|null $unit = null;

    /**
     * Decimal constructor.
     *
     * @param string      $name
     * @param string|null $label
     */
    public function __construct(string $name, ?string $label = null)
    {
        $this->setDefaultValue(0.0);
        $this->setInputMode(InputMode::Decimal);

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
     * @param Currency|string|null $unit
     *
     * @return $this
     */
    public function setUnit(Currency|string|null $unit): static
    {
        if (is_string($unit)) {
            $currency = Currency::tryFrom($unit);
        }

        $this->unit = $currency ?? $unit;

        return $this;
    }

    /**
     * Returns the unit code to be used after the decimal value
     *
     * @return Currency|string|null
     */
    public function getUnit(): Currency|string|null
    {
        return $this->unit;
    }

    /**
     * Returns whether the unit is a currency
     *
     * @return bool
     */
    public function isCurrency(): bool
    {
        return $this->unit instanceof Currency;
    }

    /**
     * Returns a currency NumberFormatter instance for the given locale
     *
     * @param string $locale
     *
     * @return false|NumberFormatter
     */
    protected function getNumberFormatter(string $locale = 'de_DE'): bool|NumberFormatter
    {
        $format = NumberFormatter::create($locale, ($this->isCurrency()) ? NumberFormatter::CURRENCY : NumberFormatter::DECIMAL);

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

        $unit = '';
        $value = $this->parseValue($value);
        $formatter = $this->getNumberFormatter();

        if ($this->isCurrency()) {
            return $formatter->formatCurrency($value, $this->getUnit()->value);
        } elseif (!empty($this->getUnit())) {
            $unit = ' ' . $this->getUnit();
        }

        return $formatter->format($value) . $unit;
    }

    /**
     * Pre validation mutator handler
     *
     * @param string $decimal
     *
     * @return float
     */
    public function preValidationMutator($decimal): float
    {
        return $this->parseValue($decimal);
    }

    /**
     * Parses a formatted decimal input string
     *
     * @param $value
     *
     * @return float
     */
    public function parseValue($value): float
    {
        if (is_float($value)) {
            return $value;
        }

        if (!$this->isCurrency() && $this->getUnit() !== null) {
            $value = str_replace($this->getUnit(), '', $value);
        }

        return floatval(str_replace(',', '.', preg_replace('/[^0-9,-]+/', '', $value)));
    }
}
