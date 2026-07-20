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
            PermissionSeeder::class,
            BranchesSeeder::class,
            UpdateBranchesIsDalamKotaSeeder::class,
            CurrencySeeder::class,
            HolidayCalendarSeeder::class,
        ]);
    }
}
