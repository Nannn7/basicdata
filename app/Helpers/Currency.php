<?php

    use Modules\Basicdata\Models\Currency;

    /**
     * Format a number as a currency string with appropriate symbol and formatting.
     *
     * This function retrieves currency information from the database and formats
     * the provided number according to the currency's specifications.
     *
     * @param float|int $number The number to be formatted as currency
     * @param string $currency The currency code (default: 'IDR')
     * @return string The formatted currency string with symbol and proper number formatting
     */
    if(!function_exists('currencyFormat')) {
        function currencyFormat($number, $currency = 'IDR') {
            $currency = Currency::where('code', $currency)->first();
            $symbol = $currency->symbol?? '';

           return $symbol . ' ' . number_format($number, $currency->decimal_places, ',', '.');
        }
    }
