<?php

    namespace Modules\Basicdata\Models;

    class Currency extends Base
    {
        protected $table = 'currencies';

        protected $fillable = [
            'code',
            'name',
            'decimal_places',
            'status',
            'authorized_at',
            'authorized_status',
            'authorized_by'
        ];
    }
