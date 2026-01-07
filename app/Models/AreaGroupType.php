<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaGroupType extends Model
{
    use SoftDeletes;

    protected $table = 'area_group_types';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'area_id',
        'group_type_id',
        'active', 
    ];
    
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class)->withTrashed();
    }

    public function groupType(): BelongsTo
    {
        return $this->belongsTo(GroupType::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);    
    }
}
