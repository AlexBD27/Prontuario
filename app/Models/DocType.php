<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocType extends Model
{

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'abbreviation',
        'description',
        'active'
    ];

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }

    public function giroTypes(): BelongsToMany
    {
        return $this->belongsToMany(GiroType::class, 'doc_type_giro_type')
            ->withPivot('active') 
            ->withTimestamps();
    }

    public function docTypeGiroTypes(): HasMany
    {
        return $this->hasMany(DocTypeGiroType::class);
    }
}
