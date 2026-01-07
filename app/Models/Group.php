<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'area_group_type_id',
        'abbreviation',
        'description',
        'active'
    ];

    public function area(): HasOneThrough
    {
        return $this->hasOneThrough(
            Area::class,
            AreaGroupType::class,
            'id', 
            'id', 
            'area_group_type_id', 
            'area_id'
        )->withTrashedParents();
    }

    public function groupType(): HasOneThrough
    {
        return $this->hasOneThrough(
            GroupType::class, 
            AreaGroupType::class,
            'id',
            'id',
            'area_group_type_id',
            'group_type_id');
    }

    public function areaGroupType(): BelongsTo
    {
        return $this->belongsTo(AreaGroupType::class, 'area_group_type_id')->withTrashed();
    }

    public function subGroups():HasMany
    {
        return $this->hasMany(Subgroup::class);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function prontuarios (): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }
}
