<?php

namespace Modules\Basicdata\Models;

use Illuminate\Database\Eloquent\Model;

class Notaris extends Model
{
    protected $table = 'notaris';

    protected $fillable = [
        'code',
        'name',
    ];
}
