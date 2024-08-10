<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbEstrategiaWmsHorarioPrioridade extends Model
{
    protected $primaryKey = 'cd_estrategia_wms_horario_prioridade';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;
}
