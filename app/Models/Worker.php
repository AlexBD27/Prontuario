<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Worker extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'group_id',
        'subgroup_id',
        'name',
        'dni',
        'position',
        'user_id'
    ];

    public function subGroup(): BelongsTo
    {
        return $this->belongsTo(Subgroup::class, 'subgroup_id', 'id')->withTrashed();
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class)->withTrashed();
    }

    public function prontuarios():HasMany
    {
        return $this->hasMany(Prontuario::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
