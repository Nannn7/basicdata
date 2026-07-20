<?php

namespace Modules\Basicdata\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Basicdata\Database\Factories\HolidayCalendarFactory;

class HolidayCalendar extends Base
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'date',
        'description',
        'type', // 'national_holiday' atau 'collective_leave'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // protected static function newFactory(): HolidayCalendarFactory
    // {
    //     // return HolidayCalendarFactory::new();
    // }
}
