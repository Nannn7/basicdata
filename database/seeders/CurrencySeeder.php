<?php

    namespace Modules\Basicdata\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    class CurrencySeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run(): void
        {
            $now = Carbon::now();
            $currencies = [
                ['code' => 'USD', 'name' => 'United States Dollar', 'symbol' => '$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'GBP', 'name' => 'British Pound Sterling', 'symbol' => '£', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥', 'decimal_places' => 0, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'SEK', 'name' => 'Swedish Krona', 'symbol' => 'kr', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'NZD', 'name' => 'New Zealand Dollar', 'symbol' => 'NZ$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'MXN', 'name' => 'Mexican Peso', 'symbol' => '$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'SGD', 'name' => 'Singapore Dollar', 'symbol' => 'S$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'HKD', 'name' => 'Hong Kong Dollar', 'symbol' => 'HK$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'NOK', 'name' => 'Norwegian Krone', 'symbol' => 'kr', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'KRW', 'name' => 'South Korean Won', 'symbol' => '₩', 'decimal_places' => 0, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'TRY', 'name' => 'Turkish Lira', 'symbol' => '₺', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'RUB', 'name' => 'Russian Ruble', 'symbol' => '₽', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'symbol' => 'Rp', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'MYR', 'name' => 'Malaysian Ringgit', 'symbol' => 'RM', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PHP', 'name' => 'Philippine Peso', 'symbol' => '₱', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'THB', 'name' => 'Thai Baht', 'symbol' => '฿', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PLN', 'name' => 'Polish Złoty', 'symbol' => 'zł', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'AED', 'name' => 'United Arab Emirates Dirham', 'symbol' => 'د.إ', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'ARS', 'name' => 'Argentine Peso', 'symbol' => '$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'CLP', 'name' => 'Chilean Peso', 'symbol' => '$', 'decimal_places' => 0, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => 'E£', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'KWD', 'name' => 'Kuwaiti Dinar', 'symbol' => 'د.ك', 'decimal_places' => 3, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'NGN', 'name' => 'Nigerian Naira', 'symbol' => '₦', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'QAR', 'name' => 'Qatari Riyal', 'symbol' => 'ر.ق', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'SAR', 'name' => 'Saudi Riyal', 'symbol' => 'ر.س', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'VND', 'name' => 'Vietnamese Dong', 'symbol' => '₫', 'decimal_places' => 0, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'ILS', 'name' => 'Israeli New Shekel', 'symbol' => '₪', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'COP', 'name' => 'Colombian Peso', 'symbol' => '$', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PEN', 'name' => 'Peruvian Sol', 'symbol' => 'S/', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
                ['code' => 'PKR', 'name' => 'Pakistani Rupee', 'symbol' => '₨', 'decimal_places' => 2, 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ];

            $currencies = array_map(static function (array $currency): array {
                $currency['deleted_at'] = null;

                return $currency;
            }, $currencies);

            DB::table('currencies')->upsert(
                $currencies,
                ['code'],
                ['name', 'symbol', 'decimal_places', 'status', 'updated_at', 'deleted_at']
            );
        }
    }
