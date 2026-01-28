<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Prontuario extends Model
{
    protected $fillable = [
        'giro_type_id',
        'doc_type_id',
        'folios',
        'date',
        'period',
        'month',
        'worker_id',
        'area_id',
        'group_id',
        'subgroup_id',
        'entity_id',
        'public_type_id',
        'number',
        'reset',
        'approved',
        'comment',
        'subject',
    ];

    protected $casts = [
        'date' => 'date',
    ];


    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class)->withTrashed();
    }

    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocType::class)->withTrashed();
    }

    public function giroType(): BelongsTo
    {
        return $this->belongsTo(GiroType::class)->withTrashed();
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class)->withTrashed();
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class)->withTrashed();
    }

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(Subgroup::class)->withTrashed();
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class)->withTrashed();
    }

    public function publicType(): BelongsTo
    {
        return $this->belongsTo(PublicType::class)->withTrashed();
    }

    public function attachment(): HasOne
    {
        return $this->hasOne(Attachment::class);
    }
}
