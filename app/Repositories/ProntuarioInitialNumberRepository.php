<?php

namespace App\Repositories;

use App\Models\ProntuarioInitialNumber;

class ProntuarioInitialNumberRepository extends BaseRepository
{
    public function __construct(ProntuarioInitialNumber $initialNumber)
    {
        parent::__construct($initialNumber);
    }

    public function findExistingRecord($tipo_giro, $doc_type_id, $area_id, $group_id, $worker_id)
    {
        return ProntuarioInitialNumber::where('giro_type_id', $tipo_giro)
            ->where('doc_type_id', $doc_type_id)
            ->where(function ($query) use ($area_id, $group_id, $worker_id) {
                if ($area_id) {
                    $query->where('area_id', $area_id);
                }
                if ($group_id) {
                    $query->where('group_id', $group_id);
                }
                if ($worker_id) {
                    $query->where('worker_id', $worker_id);
                }
            })
            ->first();
    }

    public function storeOrUpdateInitialNumber($tipo_giro, $doc_type_id, $initial_number, $area_id, $group_id, $worker_id)
    {
        $existingRecord = $this->findExistingRecord($tipo_giro, $doc_type_id, $area_id, $group_id, $worker_id);

        if ($existingRecord) {
            $existingRecord->initial_number = $initial_number;
            $existingRecord->save();
            return ['updated' => true, 'record' => $existingRecord];
        }

        $prontuarioInitial = new ProntuarioInitialNumber();
        $prontuarioInitial->giro_type_id = $tipo_giro;
        $prontuarioInitial->doc_type_id = $doc_type_id;
        $prontuarioInitial->initial_number = $initial_number;
        $prontuarioInitial->area_id = $area_id;
        $prontuarioInitial->group_id = $group_id;
        $prontuarioInitial->worker_id = $worker_id;
        $prontuarioInitial->save();

        return ['updated' => false, 'record' => $prontuarioInitial];
    }

    public function getInitialNumbers()
    {
        return ProntuarioInitialNumber::all()->keyBy(function ($item) {
            return "{$item->giro_type_id}_{$item->doc_type_id}_{$item->area_id}_{$item->group_id}_{$item->worker_id}";
        });   
    }

    public function resetInitialNumbers()
    {
        return $this->model->truncate();
    }
}