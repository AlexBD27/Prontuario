<?php

namespace App\Repositories;

use App\Models\Entity;

class EntityRepository extends BaseRepository
{
    public function __construct(Entity $entity)
    {
        parent::__construct($entity);
    }

    public function updateDocType(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $entity = $this->getById($id);
        return $entity ? (bool) $entity->active : false;
    }


}