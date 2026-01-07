<?php

namespace App\Repositories;

use App\Models\Worker;

class WorkerRepository extends BaseRepository
{
    public function __construct(Worker $entity)
    {
        parent::__construct($entity);
    }
}