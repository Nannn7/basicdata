<?php

    namespace Modules\Basicdata\Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;
    use Carbon\Carbon;

    class HolidayCalendarSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
            $now = Carbon::now();
            $holidays = [
                // Libur Nasional 2025
                [
                    'date' => '2025-01-01',
                    'description' => 'Tahun Baru 2025 Masehi',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-01-27',
                    'description' => 'Isra Miraj Nabi Muhammad SAW',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-01-29',
                    'description' => 'Tahun Baru Imlek 2576 Kongzili',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-03-29',
                    'description' => 'Hari Suci Nyepi (Tahun Baru Saka 1947)',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-03-31',
                    'description' => 'Idul Fitri 1446 Hijriah',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-01',
                    'description' => 'Idul Fitri 1446 Hijriah',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-18',
                    'description' => 'Wafat Yesus Kristus',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-20',
                    'description' => 'Kebangkitan Yesus Kristus (Paskah)',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-05-01',
                    'description' => 'Hari Buruh Internasional',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-05-12',
                    'description' => 'Hari Raya Waisak 2569 BE',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-05-29',
                    'description' => 'Kenaikan Yesus Kristus',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-06-01',
                    'description' => 'Hari Lahir Pancasila',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-06-06',
                    'description' => 'Idul Adha 1446 Hijriah',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-06-27',
                    'description' => '1 Muharam Tahun Baru Islam 1447 Hijriah',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-08-17',
                    'description' => 'Proklamasi Kemerdekaan',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-09-05',
                    'description' => 'Maulid Nabi Muhammad SAW',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-12-25',
                    'description' => 'Kelahiran Yesus Kristus',
                    'type' => 'national_holiday',
                    'created_at' => $now,
                    'updated_at' => $now
                ],

                // Cuti Bersama 2025
                [
                    'date' => '2025-01-28',
                    'description' => 'Cuti Bersama Tahun Baru Imlek 2576 Kongzili',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-03-28',
                    'description' => 'Cuti Bersama Hari Suci Nyepi (Tahun Baru Saka 1947)',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-02',
                    'description' => 'Cuti Bersama Idul Fitri',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-03',
                    'description' => 'Cuti Bersama Idul Fitri',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-04',
                    'description' => 'Cuti Bersama Idul Fitri',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-04-07',
                    'description' => 'Cuti Bersama Idul Fitri',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-05-13',
                    'description' => 'Cuti Bersama Hari Raya Waisak 2569 BE',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-05-30',
                    'description' => 'Cuti Bersama Kenaikan Yesus Kristus',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-06-09',
                    'description' => 'Cuti Bersama Idul Adha 1446 Hijriah',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'date' => '2025-12-26',
                    'description' => 'Cuti Bersama Kelahiran Yesus Kristus',
                    'type' => 'collective_leave',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
            ];

            DB::table('holiday_calendars')->insert($holidays);
        }
    }
