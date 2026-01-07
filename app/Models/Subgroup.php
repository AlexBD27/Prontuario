<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subgroup extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'group_id',
        'abbreviation',
        'description',
        'active'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }
}
