<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbEstrategiaWms extends Model
{   
    protected $primaryKey = 'cd_estrategia_wms';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;
}
