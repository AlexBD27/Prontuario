<?php

namespace App\Repositories;

use App\Models\GroupType;

class GroupTypeRepository extends BaseRepository
{
    public function __construct(GroupType $groupType)
    {
        parent::__construct($groupType);
    }

    public function updateGropuType(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $docType = $this->getById($id);
        return $docType ? (bool) $docType->active : false;
    }
}