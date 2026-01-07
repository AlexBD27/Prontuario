<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GiroType extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'abbreviation',
        'description',
        'slug',
        'active'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($giroType) {
            $giroType->slug = Str::slug($giroType->description);
        });
    }

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }

    public function docTypes(): BelongsToMany
    {
        return $this->belongsToMany(DocType::class, 'doc_type_giro_type')
            ->withPivot('active') 
            ->withTimestamps();
    }

    public function docTypeGiroTypes(): HasMany
    {
        return $this->hasMany(DocTypeGiroType::class);
    }
}
