'use strict';

var Nodus = Nodus || {};

/**
 * Decimal Input class
 *
 * @package   DTV
 * @copyright 2019 DTV Media Solutions
 * @author    Dominique Heinelt <contact@dtvmedia.de>
 * @link      http://dtvmedia.de/
 */
Nodus.DecimalInput = class {
    /**
     * DecimalInput Constructor
     *
     * @param element
     * @param options
     */
    constructor( element, options = {} ) {
        if ( typeof element === 'string' ) {
            element = document.querySelector( element );
        }

        this.element = element;
        this.options = {
            decimals: options.decimals || this.element.getAttribute( 'data-decimals' ) || Nodus.DecimalInput.DEFAULTS.decimals,
            unit: options.unit || this.element.getAttribute( 'data-unit' ) || Nodus.DecimalInput.DEFAULTS.unit,
        };

        // Event Handlers
        this.element.addEventListener( 'focus', this.onFocusHandler.bind( this ) );
        this.element.addEventListener( 'blur', this.onBlurHandler.bind( this ) );

        // Trigger formatting for preset values
        if ( this.element.value.length > 0 ) {
            this.onFocusHandler( { target: this.element } );
            this.onBlurHandler( { target: this.element } );
        }
    }

    /**
     * Returns whether or not the configured unit is a valid currency
     *
     * @return {boolean}
     */
    isValidCurrency() {
        return [ 'EUR', 'USD', 'CHF', 'DKK', 'PLN', 'CZK' ].includes( this.options.unit );
    }

    /**
     * On Focus event handler
     *
     * @param e
     */
    onFocusHandler( e ) {
        if ( e.target.value.length === 0 ) {
            return;
        }

        let value = String( this.parseInputString( e.target.value ) ).replace( /[.]+/, "," );

        if (value === '0') {
            value = '';
        }

        e.target.value = value;
    }

    /**
     * On Blur event handler
     *
     * @param e
     */
    onBlurHandler( e ) {
        let options;
        let value;

        if ( e.target.value.length === 0 ) {
            value = 0;
        } else {
            value = e.target.value;
        }

        if ( this.options.unit === null || this.isValidCurrency() === false ) {
            options = {
                maximumFractionDigits: this.options.decimals,
            }
        } else {
            options = {
                maximumFractionDigits: this.options.decimals,
                currency: this.options.unit,
                style: "currency",
                currencyDisplay: "symbol"
            }
        }

        value = this.parseInputString( value ).toLocaleString( undefined, options );

        if ( this.options.unit !== null && this.isValidCurrency() === false ) {
            value += ' ' + this.options.unit;
        }

        e.target.value = value;
    }

    /**
     * Parses the input string to a valid number
     *
     * @param s
     *
     * @return {number}
     */
    parseInputString( s ) {
        return Number( String( s ).replace( /[^0-9,-]+/g, "" ).replace( /[,]+/, "." ) );
    }

    /**
     * Returns the current numeric value
     *
     * @return {number}
     */
    getValue() {
        return this.parseInputString( this.element.value );
    }

    /**
     * Sets the current numeric value
     * @param value
     */
    setValue( value ) {
        if ( isNumeric( value ) ) {
            value = value.toLocaleString( undefined, { maximumFractionDigits: this.options.decimals } );
        }

        this.element.value = value;

        if ( (typeof value === 'string' && value.length > 0) || isNumeric( value ) ) {
            this.onFocusHandler( { target: this.element } );
            this.onBlurHandler( { target: this.element } );
        }
    }
};

Nodus.DecimalInput.DEFAULTS = {
    decimals: 2,
    unit: 'EUR',
};
