<?php

    namespace Modules\Basicdata\Models;


    class Branch extends Base
    {
        protected $table    = 'branches';
        protected $fillable = ['code', 'name', 'status', 'authorized_at', 'authorized_status', 'authorized_by'];
    }
