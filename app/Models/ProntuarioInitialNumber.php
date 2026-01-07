<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProntuarioInitialNumber extends Model
{
    protected $fillable = ['area_id', 'group_id', 'worker_id', 'giro_type_id', 'doc_type_id', 'initial_number'];
}
