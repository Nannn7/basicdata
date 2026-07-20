<?php

    namespace Modules\Basicdata\Models;

    class Currency extends Base
    {
        protected $table = 'currencies';

        protected $fillable = [
            'code',
            'name',
            'symbol',
            'decimal_places',
            'status',
            'authorized_at',
            'authorized_status',
            'authorized_by'
        ];
    }
