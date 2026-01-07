<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'abbreviation',
        'description',
        'active'
    ];

    public function areaGroupTypes(): HasMany
    {
        return $this->hasMany(AreaGroupType::class);
    }

    public function groupTypes(): BelongsToMany
    {
        return $this->belongsToMany(GroupType::class, 'area_group_types')
            ->withTimestamps()
            ->whereNull('area_group_types.deleted_at');
    }

    public function groups():HasManyThrough
    {
        return $this->hasManyThrough(Group::class, AreaGroupType::class);
    }

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }
}
