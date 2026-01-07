<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupType extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'abbreviation',
        'description',
        'active'
    ];

    public function areas(): BelongsToMany
    {
        return $this->belongsToMany(Area::class, 'area_group_types');
    }

    public function groups(): HasManyThrough
    {
        return $this->hasManyThrough(Group::class, AreaGroupType::class);
    }

    public function areaGroupTypes(): HasMany
    {
        return $this->hasMany(AreaGroupType::class);
    }

    public function filteredGroups($areaId)
    {
        return $this->hasManyThrough(Group::class, AreaGroupType::class, 'group_type_id', 'area_group_type_id')
            ->where('area_group_types.area_id', $areaId);
    }

}
