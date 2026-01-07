<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $entity)
    {
        parent::__construct($entity);
    }

    public function getUsers()
    {
        return User::where('role', 'USER')->get();
    }

}