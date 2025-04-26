<?php

namespace Modules\Basicdata\Database\Seeders;

use Illuminate\Database\Seeder;

class BasicdataDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BranchesSeeder::class,
            CurrencySeeder::class,
            HolidayCalendarSeeder::class
        ]);
    }
}
