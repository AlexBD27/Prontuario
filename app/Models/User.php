<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
        'password',
        'role',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function worker(): HasOne
    {
        return $this->hasOne(Worker::class);
    }

    public function isJefatura()
    {
        return $this->worker &&
            $this->worker->group &&
            $this->worker->group->groupType &&
            strtolower($this->worker->group->groupType->description) === 'jefatura';
    }
}
