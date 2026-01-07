<?php

namespace App\Repositories;

use App\Models\PublicType;

class PublicTypeRepository extends BaseRepository
{
    public function __construct(PublicType $publicType)
    {
        parent::__construct($publicType);
    }

    public function updatePublicType(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $publicType = $this->getById($id);
        return $publicType ? (bool) $publicType->active : false;
    }


}