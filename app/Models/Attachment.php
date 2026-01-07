<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'file_name',
        'file_path',
        'prontuario_id',
        'signed_file_path',
        'is_signed'
    ];

    public function prontuario(): BelongsTo
    {
        return $this->belongsTo(Prontuario::class);
    }

}
