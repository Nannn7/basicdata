<?php

    use Modules\Basicdata\Models\Currency;

    if(!function_exists('format_currency')) {
        function format_currency($number, $currency = 'IDR') {
            $currency = Currency::where('code', $currency)->first();
            $symbol = $currency->symbol?? '';

           return $symbol . ' ' . number_format($number, $currency->decimal_places, ',', '.');
        }
    }
