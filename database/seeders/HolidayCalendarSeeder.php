<?php

namespace Modules\Basicdata\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HolidayCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $holidays = $this->holidayRows($now);

        // Replace seeded years so rerunning the seeder does not keep duplicating rows.
        DB::table('holiday_calendars')
            ->whereBetween('date', ['2025-01-01', '2026-12-31'])
            ->delete();

        DB::table('holiday_calendars')->insert($holidays);
    }

    /**
     * Official holiday rows for seeded years.
     *
     * 2026 dates align to the 2026 government holiday announcements
     * from SKB 3 Menteri / Keppres cuti bersama ASN.
     *
     * @return array<int, array<string, mixed>>
     */
    private function holidayRows(Carbon $now): array
    {
        $rows = [
            // Libur Nasional 2025
            ['date' => '2025-01-01', 'description' => 'Tahun Baru 2025 Masehi', 'type' => 'national_holiday'],
            ['date' => '2025-01-27', 'description' => 'Isra Miraj Nabi Muhammad SAW', 'type' => 'national_holiday'],
            ['date' => '2025-01-29', 'description' => 'Tahun Baru Imlek 2576 Kongzili', 'type' => 'national_holiday'],
            ['date' => '2025-03-29', 'description' => 'Hari Suci Nyepi (Tahun Baru Saka 1947)', 'type' => 'national_holiday'],
            ['date' => '2025-03-31', 'description' => 'Idul Fitri 1446 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2025-04-01', 'description' => 'Idul Fitri 1446 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2025-04-18', 'description' => 'Wafat Yesus Kristus', 'type' => 'national_holiday'],
            ['date' => '2025-04-20', 'description' => 'Kebangkitan Yesus Kristus (Paskah)', 'type' => 'national_holiday'],
            ['date' => '2025-05-01', 'description' => 'Hari Buruh Internasional', 'type' => 'national_holiday'],
            ['date' => '2025-05-12', 'description' => 'Hari Raya Waisak 2569 BE', 'type' => 'national_holiday'],
            ['date' => '2025-05-29', 'description' => 'Kenaikan Yesus Kristus', 'type' => 'national_holiday'],
            ['date' => '2025-06-01', 'description' => 'Hari Lahir Pancasila', 'type' => 'national_holiday'],
            ['date' => '2025-06-06', 'description' => 'Idul Adha 1446 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2025-06-27', 'description' => '1 Muharam Tahun Baru Islam 1447 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2025-08-17', 'description' => 'Proklamasi Kemerdekaan', 'type' => 'national_holiday'],
            ['date' => '2025-09-05', 'description' => 'Maulid Nabi Muhammad SAW', 'type' => 'national_holiday'],
            ['date' => '2025-12-25', 'description' => 'Kelahiran Yesus Kristus', 'type' => 'national_holiday'],

            // Cuti Bersama 2025
            ['date' => '2025-01-28', 'description' => 'Cuti Bersama Tahun Baru Imlek 2576 Kongzili', 'type' => 'collective_leave'],
            ['date' => '2025-03-28', 'description' => 'Cuti Bersama Hari Suci Nyepi (Tahun Baru Saka 1947)', 'type' => 'collective_leave'],
            ['date' => '2025-04-02', 'description' => 'Cuti Bersama Idul Fitri', 'type' => 'collective_leave'],
            ['date' => '2025-04-03', 'description' => 'Cuti Bersama Idul Fitri', 'type' => 'collective_leave'],
            ['date' => '2025-04-04', 'description' => 'Cuti Bersama Idul Fitri', 'type' => 'collective_leave'],
            ['date' => '2025-04-07', 'description' => 'Cuti Bersama Idul Fitri', 'type' => 'collective_leave'],
            ['date' => '2025-05-13', 'description' => 'Cuti Bersama Hari Raya Waisak 2569 BE', 'type' => 'collective_leave'],
            ['date' => '2025-05-30', 'description' => 'Cuti Bersama Kenaikan Yesus Kristus', 'type' => 'collective_leave'],
            ['date' => '2025-06-09', 'description' => 'Cuti Bersama Idul Adha 1446 Hijriah', 'type' => 'collective_leave'],
            ['date' => '2025-12-26', 'description' => 'Cuti Bersama Kelahiran Yesus Kristus', 'type' => 'collective_leave'],

            // Libur Nasional 2026
            ['date' => '2026-01-01', 'description' => 'Tahun Baru 2026 Masehi', 'type' => 'national_holiday'],
            ['date' => '2026-01-03', 'description' => 'Isra Miraj Nabi Muhammad SAW', 'type' => 'national_holiday'],
            ['date' => '2026-02-17', 'description' => 'Tahun Baru Imlek 2577 Kongzili', 'type' => 'national_holiday'],
            ['date' => '2026-03-19', 'description' => 'Hari Suci Nyepi (Tahun Baru Saka 1948)', 'type' => 'national_holiday'],
            ['date' => '2026-03-21', 'description' => 'Idul Fitri 1447 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2026-03-22', 'description' => 'Idul Fitri 1447 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2026-04-03', 'description' => 'Wafat Yesus Kristus', 'type' => 'national_holiday'],
            ['date' => '2026-04-05', 'description' => 'Kebangkitan Yesus Kristus (Paskah)', 'type' => 'national_holiday'],
            ['date' => '2026-05-01', 'description' => 'Hari Buruh Internasional', 'type' => 'national_holiday'],
            ['date' => '2026-05-14', 'description' => 'Kenaikan Yesus Kristus', 'type' => 'national_holiday'],
            ['date' => '2026-05-27', 'description' => 'Idul Adha 1447 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2026-05-31', 'description' => 'Hari Raya Waisak 2570 BE', 'type' => 'national_holiday'],
            ['date' => '2026-06-01', 'description' => 'Hari Lahir Pancasila', 'type' => 'national_holiday'],
            ['date' => '2026-06-16', 'description' => '1 Muharam Tahun Baru Islam 1448 Hijriah', 'type' => 'national_holiday'],
            ['date' => '2026-08-17', 'description' => 'Proklamasi Kemerdekaan', 'type' => 'national_holiday'],
            ['date' => '2026-08-28', 'description' => 'Maulid Nabi Muhammad SAW', 'type' => 'national_holiday'],
            ['date' => '2026-12-25', 'description' => 'Kelahiran Yesus Kristus', 'type' => 'national_holiday'],

            // Cuti Bersama 2026
            ['date' => '2026-02-16', 'description' => 'Cuti Bersama Tahun Baru Imlek 2577 Kongzili', 'type' => 'collective_leave'],
            ['date' => '2026-03-18', 'description' => 'Cuti Bersama Hari Suci Nyepi (Tahun Baru Saka 1948)', 'type' => 'collective_leave'],
            ['date' => '2026-03-20', 'description' => 'Cuti Bersama Idul Fitri 1447 Hijriah', 'type' => 'collective_leave'],
            ['date' => '2026-03-23', 'description' => 'Cuti Bersama Idul Fitri 1447 Hijriah', 'type' => 'collective_leave'],
            ['date' => '2026-03-24', 'description' => 'Cuti Bersama Idul Fitri 1447 Hijriah', 'type' => 'collective_leave'],
            ['date' => '2026-05-15', 'description' => 'Cuti Bersama Kenaikan Yesus Kristus', 'type' => 'collective_leave'],
            ['date' => '2026-05-28', 'description' => 'Cuti Bersama Idul Adha 1447 Hijriah', 'type' => 'collective_leave'],
            ['date' => '2026-12-24', 'description' => 'Cuti Bersama Kelahiran Yesus Kristus', 'type' => 'collective_leave'],
        ];

        return array_map(static function (array $holiday) use ($now): array {
            return $holiday + [
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ];
        }, $rows);
    }
}
