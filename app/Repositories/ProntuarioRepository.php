<?php

namespace App\Repositories;

use App\Models\Prontuario;
use DB;
use Illuminate\Database\Eloquent\Collection;

class ProntuarioRepository extends BaseRepository
{
    protected WorkerRepository $workerRepository;
    
    public  function __construct(Prontuario $prontuario, WorkerRepository $workerRepository)
    {
        parent::__construct($prontuario);
        $this->workerRepository = $workerRepository;
    }

    public function getDistinctYears()
    {
        return $this->model->select('period')->distinct()->pluck('period');
    }

    public function getWithRelations(array $relations)
    {
        return $this->model->with($relations)->get();
    }

    public function getWithRelationsByActualPeriod(array $relations)
    {
        $inicioLote = $this->model->where('reset', 0)->orderBy('date', 'desc')->first();

        if (!$inicioLote) {
            return $this->model->where('reset', 1)->with($relations)->get();
        }
        return $this->model->where('id', '>', $inicioLote->id)->with($relations)->get();
    }

    public function getMaxNumberForContext(?int $workerId, $giroType, int $docTypeId): int
    {
        $registrosPeriodoActual = $this->getByActualPeriod();
        $worker = $this->workerRepository->getById($workerId);

        $numeroInicial = DB::table('prontuario_initial_numbers')
            ->where('giro_type_id', $giroType->id)
            ->where('doc_type_id', $docTypeId)
            ->when($giroType->slug === 'internos' || $giroType->slug === 'publicos', function ($query) use ($worker) {
                return $query->where('area_id', $worker->group->area->id);
            })
            ->when($giroType->slug === 'entre-equipos', function ($query) use ($worker) {
                return $query->where('group_id', $worker->group->id);
            })
            ->when($giroType->slug === 'personales', function ($query) use ($workerId) {
                return $query->where('worker_id', $workerId);
            })
            ->value('initial_number') ?? 1;

        if ($giroType->slug === 'internos' || $giroType->slug === 'publicos') {
            $responsibleAreaId = $worker->group->area->id;
            $maxNumber = $registrosPeriodoActual
                ->whereHas('worker.group.area', function ($query) use ($responsibleAreaId) {
                    $query->where('areas.id', $responsibleAreaId);
                })
                ->where('giro_type_id', $giroType->id)
                ->where('doc_type_id', $docTypeId)
                ->max('number');
        } elseif ($giroType->slug === 'externos') {
            $maxNumber = $registrosPeriodoActual
                ->where('giro_type_id', $giroType->id)
                ->where('doc_type_id', $docTypeId)
                ->max('number');
        } elseif ($giroType->slug === 'entre-equipos') {
            $responsibleGroupId = $worker->group->id;
            $maxNumber = $registrosPeriodoActual
                ->whereHas('worker.group', function ($query) use ($responsibleGroupId) {
                    $query->where('groups.id', $responsibleGroupId);
                })
                ->where('giro_type_id', $giroType->id)
                ->where('doc_type_id', $docTypeId)
                ->max('number');
        } elseif ($giroType->slug === 'personales') {
            $maxNumber = $registrosPeriodoActual
                ->where('giro_type_id', $giroType->id)
                ->where('doc_type_id', $docTypeId)
                ->where('worker_id', $workerId)
                ->max('number');
        } else {
            throw new \Exception('Tipo de giro no válido.');
        }

        return max($maxNumber + 1, $numeroInicial);
    }

    public function findByFields(array $conditions, array $relations = [], string $orderBy = 'number', string $direction = 'desc'): Collection
    {
        $query = $this->getByActualPeriod();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        if (!empty($relations)) {
            $query->with($relations);
        }

        $query->orderBy($orderBy, $direction);

        return $query->get();
    }

    public function findByField(string $field, $value): Collection
    {
        $query = $this->getByActualPeriod()->where($field, $value);
        return $query->get();
    }
    

    public function countByField(string $field, $value, ?int $areaId = null, ?int $workerId = null): int
    {
        $query = $this->getByActualPeriod()->where($field, $value);

        if ($areaId) {
            $query->whereHas('worker.group.areaGroupType.area', function ($query) use ($areaId) {
                $query->where('id', $areaId);
            });
        }

        if($workerId) {
            $query->where('worker_id', $workerId);
        }

        return $query->count();
    }

    public function countByConditions(array $conditions, ?int $areaId = null, ?int $workerId = null): int 
    {
        $query = $this->getByActualPeriod();

        foreach ($conditions as $field => $value) {
            $query->where($field, $value);
        }

        if ($areaId) {
            $query->whereHas('worker.group.areaGroupType.area', function ($query) use ($areaId) {
                $query->where('id', $areaId);
            });
        }

        if ($workerId) {
            $query->where('worker_id', $workerId);
        }

        return $query->count();
    }


    public function groupByArea(?int $areaId = null)
    {
        $inicioLote = $this->model->where('reset', 0)->orderBy('created_at', 'desc')->first();
        $query = $this->model->newQuery();

        if ($inicioLote) {
            $query->where('prontuarios.id', '>', $inicioLote->id);
        }

        if ($areaId) {
            return $query
                ->select(
                    'groups.abbreviation as area_abbreviation',
                    'groups.description as area_description',
                    DB::raw('count(prontuarios.id) as total')
                )
                ->join('workers', 'prontuarios.worker_id', '=', 'workers.id')
                ->join('groups', 'workers.group_id', '=', 'groups.id')
                ->join('area_group_types', 'groups.area_group_type_id', '=', 'area_group_types.id')
                ->where('area_group_types.area_id', $areaId)
                ->groupBy('groups.abbreviation', 'groups.description')
                ->get();
        }

        return $query
            ->select(
                'areas.abbreviation as area_abbreviation',
                'areas.description as area_description',
                DB::raw('count(prontuarios.id) as total')
            )
            ->join('workers', 'prontuarios.worker_id', '=', 'workers.id')
            ->join('groups', 'workers.group_id', '=', 'groups.id')
            ->join('area_group_types', 'groups.area_group_type_id', '=', 'area_group_types.id')
            ->join('areas', 'area_group_types.area_id', '=', 'areas.id')
            ->groupBy('areas.abbreviation', 'areas.description')
            ->get();
    }

    public function groupByDocumentType(?int $areaId = null)
    {
        $inicioLote = $this->model->where('reset', 0)->orderBy('created_at', 'desc')->first();

        $query = $this->model
            ->select(
                'doc_types.abbreviation as doc_type_name',
                'doc_types.description as doc_type_description',
                DB::raw('count(prontuarios.id) as total')
            )
            ->join('doc_types', 'prontuarios.doc_type_id', '=', 'doc_types.id')
            ->join('workers', 'prontuarios.worker_id', '=', 'workers.id')
            ->join('groups', 'workers.group_id', '=', 'groups.id')
            ->join('area_group_types', 'groups.area_group_type_id', '=', 'area_group_types.id')
            ->groupBy('doc_types.abbreviation', 'doc_types.description');

        if ($inicioLote) {
            $query->where('prontuarios.id', '>', $inicioLote->id);
        }

        if ($areaId) {
            $query->where('area_group_types.area_id', $areaId);
        }

        return $query->get();
    }

    public function groupByMonth(?int $areaId = null)
    {
        $inicioLote = $this->model->where('reset', 0)->orderBy('created_at', 'desc')->first();

        $query = $this->model
            ->select('month', DB::raw('count(*) as total'))
            ->join('workers', 'prontuarios.worker_id', '=', 'workers.id')
            ->join('groups', 'workers.group_id', '=', 'groups.id')
            ->join('area_group_types', 'groups.area_group_type_id', '=', 'area_group_types.id')
            ->groupBy('month')
            ->orderBy('month');

        if ($inicioLote) {
            $query->where('prontuarios.id', '>', $inicioLote->id);
        }

        if ($areaId) {
            $query->where('area_group_types.area_id', $areaId);
        }

        return $query->get();
    }

    public function getByActualPeriod ()
    {
        $inicioLote = $this->model->where('reset', 0)->orderBy('created_at', 'desc')->first();

        if (!$inicioLote) {
            return $this->model->where('reset', 1);
        }
        return $this->model->where('id', '>', $inicioLote->id);
    }

    public function getBySpecificPeriod($year)
    {
        $inicioLote = $this->model->whereYear('date', $year)
            ->where('reset', 0)
            ->orderBy('date', 'asc')
            ->first();

        if (!$inicioLote) {
            return $this->model->whereYear('date', $year)
                ->where('reset', 1)
                ->get();
        }

        $finLote = $this->model->where('reset', 0)
            ->where('id', '>', $inicioLote->id)
            ->orderBy('fecha', 'asc')
            ->first();

        $query = $this->model->where('id', '>', $inicioLote->id);

        if ($finLote) {
            $query->where('id', '<=', $finLote->id);
        }

        return $query->get();
    }

    public function getBetweenDates($startDate, $endDate)
    {
        return $this->model->whereBetween('date', [$startDate, $endDate])->get();
    }

    public function getCmLinealesByDocTypeAndPeriod($startDate, $endDate)
    {
        return $this->model
            ->whereBetween('date', [$startDate, $endDate])
            ->select('doc_type_id', 'folios')
            ->get();
    }

    public function resetProntuario()
    {
        $lastProntuario = Prontuario::where('reset', 1)
                                    ->latest()
                                    ->first();

        if ($lastProntuario) {
            $lastProntuario->update(['reset' => 0]);
        }

        return $lastProntuario;
    }

    public function getExternalWithSignatureStatus(?bool $signed = null, string $orderBy = 'number', string $direction = 'desc') {
        
        $direction = strtolower($direction) === 'asc' ? 'asc' : 'desc';

        $query = Prontuario::with([
                'attachment',
                'worker.group',
                'worker.subGroup'
            ])
            ->whereHas('giroType', function ($q) {
                $q->where('slug', 'externos');
            });

        if ($signed === true) {
            $query->whereHas('attachment', function ($q) {
                $q->where('is_signed', 1);
            });
        } elseif ($signed === false) {
            $query->where(function ($q) {
                $q->doesntHave('attachment')
                ->orWhereHas('attachment', function ($qa) {
                    $qa->where('is_signed', 0);
                });
            });
        }

        return $query->orderBy($orderBy, $direction)->get();
    }
}