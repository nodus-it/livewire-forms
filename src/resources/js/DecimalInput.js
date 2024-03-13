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
    constructor(element, options = {}) {
        if (typeof element === 'string') {
            element = document.querySelector(element);
        }

        this.element = element;
        this.options = {
            decimals: options.decimals || this.element.getAttribute('data-decimals') || Nodus.DecimalInput.DEFAULTS.decimals,
            unit: options.unit || this.element.getAttribute('data-unit') || Nodus.DecimalInput.DEFAULTS.unit,
        };

        // Event Handlers
        this.element.addEventListener('focus', this.onFocusHandler.bind(this));
        this.element.addEventListener('blur', this.onBlurHandler.bind(this));

        // Trigger formatting for preset values
        if (this.element.value.length > 0) {
            this.onFocusHandler({target: this.element});
            this.onBlurHandler({target: this.element});
        }
    }

    /**
     * Returns whether the configured unit is a valid currency
     *
     * @return {boolean}
     */
    isValidCurrency() {
        return [
            'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN',
            'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BOV', 'BRL', 'BSD', 'BTN', 'BWP', 'BYR', 'BZD', 'CAD', 'CDF',
            'CHE', 'CHF', 'CHW', 'CLF', 'CLP', 'CNY', 'COP', 'COU', 'CRC', 'CUC', 'CUP', 'CVE', 'CZK', 'DJF',
            'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GHS', 'GIP', 'GMD',
            'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'IQD', 'IRR', 'ISK',
            'JMD', 'JOD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP',
            'LKR', 'LRD', 'LSL', 'LTL', 'LVL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO',
            'MUR', 'MVR', 'MWK', 'MXN', 'MXV', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'OMR',
            'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD',
            'SCR', 'SDG', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'SSP', 'STD', 'SYP', 'SZL', 'THB', 'TJS',
            'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'USN', 'USS', 'UYI', 'UYU',
            'UZS', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XAG', 'XAU', 'XBA', 'XBB', 'XBC', 'XBD', 'XCD', 'XDR',
            'XOF', 'XPD', 'XPF', 'XPT', 'XTS', 'XXX', 'YER', 'ZAR', 'ZMW',
        ].includes(this.options.unit);
    }

    /**
     * On Focus event handler
     *
     * @param e
     */
    onFocusHandler(e) {
        if (e.target.value.length === 0) {
            return;
        }

        let value = String(this.parseInputString(e.target.value)).replace(/[.]+/, ",");

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
    onBlurHandler(e) {
        let options;
        let value;

        if (e.target.value.length === 0) {
            value = 0;
        } else {
            value = e.target.value;
        }

        if (this.options.unit === null || this.isValidCurrency() === false) {
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

        value = this.parseInputString(value).toLocaleString(undefined, options);

        if (this.options.unit !== null && this.options.unit !== '_NO_UNIT' && this.isValidCurrency() === false) {
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
    parseInputString(s) {
        if (this.options.unit !== null && this.options.unit !== '_NO_UNIT' && this.isValidCurrency() === false) {
            s = String(s).replace(this.options.unit, "")
        }

        return Number(String(s).replace(/[^0-9,-]+/g, "").replace(/,+/, "."));
    }

    /**
     * Returns the current numeric value
     *
     * @return {number}
     */
    getValue() {
        return this.parseInputString(this.element.value);
    }

    /**
     * Sets the current numeric value
     * @param value
     */
    setValue(value) {
        if (!isNaN(value)) {
            value = value.toLocaleString(undefined, {maximumFractionDigits: this.options.decimals});
        }

        this.element.value = value;

        if ((typeof value === 'string' && value.length > 0) || !isNaN(value)) {
            this.onFocusHandler({target: this.element});
            this.onBlurHandler({target: this.element});
        }
    }
};

Nodus.DecimalInput.DEFAULTS = {
    decimals: 2,
    unit: 'EUR',
};
