<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocTypeGiroType extends Model
{

    protected $table = 'doc_type_giro_type';

    protected $fillable = [
        'doc_type_id',
        'giro_type_id',
        'active'
    ];

    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocType::class);
    }

    public function giroType(): BelongsTo
    {
        return $this->belongsTo(GiroType::class);
    }

    
}
