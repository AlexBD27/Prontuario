<?php

namespace App\Repositories;

use App\Models\Group;

class GroupRepository extends BaseRepository
{
    public function __construct(Group $group)
    {
        parent::__construct($group);
    }

    public function updateGroup(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $group = $this->getById($id);
        return $group ? (bool) $group->active : false;
    }


}