<?php

    namespace Modules\Basicdata\Models;

    use Illuminate\Database\Eloquent\Model;

    class Developer extends Model
    {
        protected $table = 'developer';

        protected $fillable = [
            'code',
            'name',
        ];
    }
