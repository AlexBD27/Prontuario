<?php

namespace App\Repositories;

use App\Models\Subgroup;

class SubgroupRepository extends BaseRepository
{
    public function __construct(Subgroup $subgroup)
    {
        parent::__construct($subgroup);
    }

    public function updateSubgroup(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $subgroup = $this->getById($id);
        return $subgroup ? (bool) $subgroup->active : false;
    }


}