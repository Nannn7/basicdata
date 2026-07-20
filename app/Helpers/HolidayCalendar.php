<?php

    use Carbon\Carbon;
    use Modules\Basicdata\Models\HolidayCalendar;

    /**
     * Calculate the number of working days between two dates.
     *
     * This function counts the number of days that are not weekends and not holidays
     * between the given start and end dates (inclusive).
     *
     * @param string|Carbon $startDate The starting date for the calculation
     * @param string|Carbon $endDate The ending date for the calculation
     * @return int The number of working days between the two dates
     */
    if (!function_exists('workingDays')) {
        function workingDays($startDate, $endDate)
        {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $endDate   = Carbon::parse($endDate)->endOfDay();

            $workingDay = 0;
            $now        = $startDate->copy();

            while ($now <= $endDate) {
                if (!$now->isWeekend() && !in_array($now->format('Y-m-d'), holidays())) {
                    $workingDay++;
                }
                $now->addDay();
            }

            return $workingDay;
        }
    }


    /**
     * Get a list of all holiday dates from the holiday calendar.
     *
     * This function retrieves all holiday dates from the HolidayCalendar model
     * and formats them as Y-m-d strings for easy comparison in date calculations.
     *
     * @return array An array of holiday dates in Y-m-d format
     */
    if (!function_exists('holidays')) {
        function holidays()
        {
            return HolidayCalendar::pluck('date')->map(
                function ($item) {
                    return Carbon::parse($item)->format('Y-m-d');
                },
            )->toArray();
        }
    }
