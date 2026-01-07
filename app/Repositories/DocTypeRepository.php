<?php

namespace App\Repositories;

use App\Models\DocType;

class DocTypeRepository extends BaseRepository
{
    protected GiroTypeRepository $giroTypeRepository;

    public function __construct(DocType $docType, GiroTypeRepository $giroTypeRepository)
    {
        parent::__construct($docType);
        $this->giroTypeRepository = $giroTypeRepository;
    }

    public function updateDocType(int $id, array $data): bool
    {
        $data['active'] = isset($data['active']) ? 1 : 0;
        return $this->update($id, $data);
    }

    public function isActive(int $id):bool
    {
        $docType = $this->getById($id);
        return $docType ? (bool) $docType->active : false;
    }

    public function getByGiroType($slug)
    {
        $giroType = $this->giroTypeRepository->findBy('slug', $slug)->first();

        if (!$giroType) {
            return collect();
        }

        return $this->model->where('active', true)
            ->whereHas('giroTypes', function ($query) use ($giroType) {
                $query->where('giro_types.id', operator: $giroType->id);
            })->get();
    }

}