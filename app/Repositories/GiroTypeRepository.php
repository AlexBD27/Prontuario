<?php

namespace App\Repositories;

use App\Models\GiroType;

class GiroTypeRepository extends BaseRepository
{
    public function __construct(GiroType $giroType)
    {
        parent::__construct($giroType);
    }

    public function updateGiroType(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $giroType = $this->getById($id);
        return $giroType ? (bool) $giroType->active : false;
    }
}