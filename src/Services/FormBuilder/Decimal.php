<?php

    namespace Nodus\Packages\LivewireForms\Services\FormBuilder;

    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsDefaultValue;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsSize;
    use Nodus\Packages\LivewireForms\Services\FormBuilder\Traits\SupportsValidations;

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

        // Todo direkt eigene Decimal Validation hinzufügen
        // Todo GUI Handling fixen

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
        protected ?string $unit = null;

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
        public function setDecimals(int $decimals)
        {
            $this->decimals = $decimals;

            return $this;
        }

        /**
         * Returns the number of decimals to be shown of the decimal value
         *
         * @return int
         */
        public function getDecimals()
        {
            return $this->decimals;
        }

        /**
         * Set the unit to be shown after the decimal value
         *
         * @param string $unit
         *
         * @return $this
         */
        public function setUnit(string $unit)
        {
            $this->unit = $unit;

            return $this;
        }

        /**
         * Returns the unit to be shown after the decimal value
         *
         * @return string|null
         */
        public function getUnit()
        {
            return $this->unit;
        }

        /**
         * Pre validation mutator handler
         *
         * @param string $decimal
         *
         * @return float
         */
        public function preValidationMutator(string $decimal)
        {
            return static::parseValue($decimal);
        }

        /**
         * Parses an formatted decimal input string
         *
         * @param $value
         *
         * @return float
         */
        public static function parseValue( $value )
        {
            if ( is_float( $value ) ) {
                return $value;
            }

            return floatval( str_replace( ',' , '.' , preg_replace( '/[^0-9,-]+/' , '' , $value ) ) );
        }
    }
