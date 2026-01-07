<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'abbreviation',
        'description',
        'active',
    ];

    public function prontuarios(): HasMany
    {
        return $this->hasMany(Prontuario::class);
    }
}
