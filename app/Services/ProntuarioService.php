<?php

namespace App\Services;

use App\Models\Attachment;
use App\Models\Group;
use App\Models\Worker;
use App\Repositories\AreaRepository;
use App\Repositories\DocTypeRepository;
use App\Repositories\EntityRepository;
use App\Repositories\GiroTypeRepository;
use App\Repositories\ProntuarioRepository;
use App\Repositories\PublicTypeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProntuarioService
{
    protected ProntuarioRepository $prontuarioRepository;
    protected AreaRepository $areaRepository;
    protected EntityRepository $entityRepository;
    protected DocTypeRepository $docTypeRepository;
    protected GiroTypeRepository $giroTypeRepository;
    protected PublicTypeRepository $publicTypeRepository;

    public function __construct(ProntuarioRepository $prontuarioRepository, AreaRepository $areaRepository, EntityRepository $entityRepository, DocTypeRepository $docTypeRepository, GiroTypeRepository $giroTypeRepository, PublicTypeRepository $publicTypeRepository)
    {
        $this->prontuarioRepository = $prontuarioRepository;
        $this->areaRepository = $areaRepository;
        $this->entityRepository = $entityRepository;
        $this->docTypeRepository  = $docTypeRepository;
        $this->giroTypeRepository = $giroTypeRepository;
        $this->publicTypeRepository = $publicTypeRepository;
    }

    public function getAll(): Collection
    {
        return $this->prontuarioRepository->getAll();
    }

    public function getTotalProntuarios(): int
    {
        return $this->prontuarioRepository->count();
    }

    public function getById(int $id)
    {
        return $this->prontuarioRepository->getById($id);
    }

    public function getByIdWithRelations(int $id, $relations)
    {
        return $this->prontuarioRepository->getByIdWithRelations($id, $relations);
    }

    public function create(array $data, int $worker_id)
    {

        $tipoGiro = $this->giroTypeRepository->findBy('slug', $data['tipo_giro'])->firstOrFail();

        if(!$tipoGiro)
        {
            throw new \Exception('Tipo de giro no encontrado.');
        }

        $this->validateProntuarioContext($data, $tipoGiro->slug);

        $dateNow = now();

        $newProntuarioData = [
            // 'giro_type_id' => $data['tipo_giro'],
            'giro_type_id' => $tipoGiro->id,
            'doc_type_id' => $data['document_id'],
            'folios' => $data['folios'],
            'subject' => $data['subject'],
            'date' => $dateNow->toDateString(),
            'period' => $dateNow->year,
            'month' => $dateNow->month,
            'worker_id' => $worker_id,
            'area_id' => $data['area'] ?? null,
            'group_id' => $data['grupo'] ?? null,
            'subgroup_id' => $data['subgrupo'] ?? null,
            'entity_id' => $data['entidad_externa'] ?? null,
            'public_type_id' => $data['tipo_publico'] ?? null,
        ];



        $maxNumber = $this->prontuarioRepository->getMaxNumberForContext(
            $newProntuarioData['worker_id'],
            $tipoGiro,
            $newProntuarioData['doc_type_id'],
        );

        $newProntuarioData['number'] = $maxNumber;

        return $this->prontuarioRepository->create($newProntuarioData);
    }

    public function updateProntuario(int $id, array $data)
    {
        $prontuario = $this->getById($id);

        if (!$prontuario) {
            throw new \Exception("Registro no encontrado.");
        }

        $tipoGiro = $this->giroTypeRepository->findBy('slug', $data['tipo_giro'])->firstOrFail();
        //$tipoGiro = $this->giroTypeRepository->getById($data['tipo_giro']); //obtener el giroType de la bd y pasarle el slug al validate

        if(!$tipoGiro)
        {
            throw new \Exception('Tipo de giro no encontrado.');
        }

        $this->validateProntuarioContext($data, $tipoGiro->slug);

        $currentGiroType = $prontuario->giro_type_id;
        $currentDocType = $prontuario->doc_type_id;

        $shouldUpdateNumber = 
            $currentGiroType !== (int) $tipoGiro->id ||
            $currentDocType !== (int) $data['document_id'];

        // $shouldUpdateNumber = 
        //     $currentGiroType !== (int) $data['tipo_giro'] ||
        //     $currentDocType !== (int) $data['document_id'];

        $newNumber = $prontuario->number;
        if ($shouldUpdateNumber) {
            $newNumber = $this->getMaxNumberForContext(
                $prontuario->worker->id,
                $tipoGiro, //$data['tipo_giro']
                (int) $data['document_id']
            );
        }

        $prontuario->update([
            'folios' => $data['folios'],
            'giro_type_id' => (int) $tipoGiro->id, //data['tipo_giro']
            'doc_type_id' => (int) $data['document_id'],
            'subject' => $data['subject'],
            'area_id' => $data['area'] ?? null, 
            'group_id' => $data['grupo'] ?? null,
            'subgroup_id' => $data['subgrupo'] ?? null,
            'entity_id' => $data['entidad_externa'] ?? null,
            'public_type_id' => $data['tipo_publico'] ?? null,
            'comment' => $data['comment'] ?? null,
            'approved' => (int) $data['approved'],
            'number' => $newNumber,
        ]);

        return $prontuario;
    }


    public function update(int $id, array $data): bool
    {
        return $this->prontuarioRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->prontuarioRepository->delete($id);
    }

    public function getProntuariosWithRelations(array $data): Collection
    {
        return $this->prontuarioRepository->getWithRelationsByActualPeriod($data);
    }

    public function getDataFormCreation(): array
    {
        return [
            'areas' => $this->areaRepository->getWithRelations(),
            'giros' => $this->giroTypeRepository->getAll(),
            'doc_types' => $this->docTypeRepository->getAll(),
            'entities' => $this->entityRepository->getAll(),
            'public_types' => $this->publicTypeRepository->getAll(),
        ];
    }

    public function getDataWorkerFormCreation($slug): array
    {
        return [
            'areas' => $this->areaRepository->getWithRelations(),
            'giros' => $this->giroTypeRepository->getActives(),
            'doc_types' => $this->docTypeRepository->getByGiroType($slug),
            'entities' => $this->entityRepository->getActives(),
            'public_types' => $this->publicTypeRepository->getActives(),
        ];
    }

    public function getProntuariosByField(string $field, $value, array $relations = []): Collection
    {
        return $this->prontuarioRepository->findBy($field, $value, $relations);
    }

    public function getProntuariosByFieldActualPeriod(string $field, $value): Collection
    {
        if($value != 0)
        {
            return $this->prontuarioRepository->findByField($field, $value);
        }
        
        return $this->getTotalByActualPeriod();
    }

    public function getProntuariosByFields(array $conditions, array $relations = [], string $orderBy = 'number', string $direction = 'desc'): Collection
    {
        return $this->prontuarioRepository->findByFields($conditions, $relations, $orderBy, $direction);
    }

    public function getProntuariosByWorkerActualPeriod(int $id): Collection
    {      
        $conditions = [
            'worker_id' => $id,
        ];
        
        return $this->prontuarioRepository->findByFields($conditions);
    }

    public function getProntuariosByWorkerDoctypeActualPeriod(int $id, int $doctype)
    {
        if($doctype != 0)
        {
            $conditions = [
                'worker_id' => $id,
                'doc_type_id' => $doctype,
            ];

            return $this->prontuarioRepository->findByFields($conditions);
        }

        return $this->getProntuariosByWorkerActualPeriod($id);
    }

    public function getProntuariosByWorkerDerivationActualPeriod(int $id, int $girotype)
    {
        if($girotype != 0)
        {
            $conditions = [
                'worker_id' => $id,
                'giro_type_id' => $girotype,
            ];

            return $this->prontuarioRepository->findByFields($conditions);
        }

        return $this->getProntuariosByWorkerActualPeriod($id);
    }

    public function getProntuariosByWorkerYearAndMonths($worker_id, $year, $months)
    {
        return $this->prontuarioRepository->findByMultipleConditions([
            ['worker_id', '=', $worker_id],
            ['period', '=', $year],
            ['month', 'IN', $months],
        ]);
    }

    public function getProntuariosByWorkerCustomFields($worker_id, $year, $months, $giroType, $doctype)
    {
        $conditions = [
            ['worker_id', '=', $worker_id],
        ];

        if ($giroType != 0) {
            $conditions[] = ['giro_type_id', '=', $giroType];
        }

        if ($doctype != 0) {
            $conditions[] = ['doc_type_id', '=', $doctype];
        }

        if ($year != 0) {
            $conditions[] = ['period', '=', $year];
        }

        if (!empty($months)) {
            $conditions[] = ['month', 'IN', $months];
        }

        return $this->prontuarioRepository->findByMultipleConditions($conditions);
    }

    public function getProntuariosAdminCustomFields($area = 0, $groupType = 0, $group = 0, $worker_id = 0, $year =0, $months, $giroType = 0, $doctype = 0)
    {
        $conditions = [];

        if ($worker_id != 0) {
            $conditions[] = ['worker_id', '=', $worker_id];
        } else {
            if ($group != 0) {
                $workerIds = Worker::where('group_id', $group)->pluck('id');
                $conditions[] = ['worker_id', 'IN', $workerIds];
            } else {
                if ($groupType != 0) {
                    $groupIds = Group::whereHas('areaGroupType', function ($query) use ($groupType, $area) {
                        $query->where('group_type_id', $groupType);
                        if ($area != 0) {
                            $query->where('area_id', $area);
                        }
                    })->pluck('id');
                
                    $workerIds = Worker::whereIn('group_id', $groupIds)->pluck('id');
                    $conditions[] = ['worker_id', 'IN', $workerIds];
                } else {
                    if ($area != 0) {
                        $groupIds = Group::whereHas('areaGroupType', function ($query) use ($area) {
                            $query->where('area_id', $area);
                        })->pluck('id');
                    
                        $workerIds = Worker::whereIn('group_id', $groupIds)->pluck('id');
                        $conditions[] = ['worker_id', 'IN', $workerIds];
                    }
                }
            }
        }

        if ($giroType != 0) {
            $conditions[] = ['giro_type_id', '=', $giroType];
        }

        if ($doctype != 0) {
            $conditions[] = ['doc_type_id', '=', $doctype];
        }

        if ($year != 0) {
            $conditions[] = ['period', '=', $year];
        }

        if (!empty($months)) {
            $conditions[] = ['month', 'IN', $months];
        }

        return $this->prontuarioRepository->findByMultipleConditions($conditions);
    }

    public function getProntuariosByYearAndMonths($year, $months)
    {
        return $this->prontuarioRepository->findByMultipleConditions([
            ['period', '=', $year],
            ['month', 'IN', $months],
        ]);
    }

    public function getTotalByActualPeriod()
    {
        return $this->prontuarioRepository->getByActualPeriod()->get();
    }

    public function getTotalBySpecificPeriod($year)
    {
        return $this->prontuarioRepository->getBySpecificPeriod($year);
    }

    public function getTotalByField(string $field, $value, ?int $areaId = null, ?int $workerId = null): int
    {
        return $this->prontuarioRepository->countByField($field, $value, $areaId, $workerId);
    }

    private function validateProntuarioContext(array $data, $tipoGiro): void
    {
        //$tipoGiro = (int) $data['tipo_giro'];

        if ($tipoGiro === 'externos' && empty($data['entidad_externa'])) {
            throw new \InvalidArgumentException("Para giros externos, la entidad externa es obligatoria.");
        }

        if ($tipoGiro === 'internos' || $tipoGiro === 'entre-equipos') {
            if (empty($data['area'])) {
                throw new \InvalidArgumentException("Para giros internos o entre equipos, el área es obligatoria.");
            }
            if (empty($data['grupo'])) {
                throw new \InvalidArgumentException("Para giros internos o entre equipos, el grupo es obligatorio.");
            }
        }

        if ($tipoGiro === 'publicos' && empty($data['tipo_publico'])) {
            throw new \InvalidArgumentException("Para giros públicos, el tipo de público es obligatorio.");
        }
    }

    public function getProntuariosPorArea(?int $areaId = null)
    {
        return $this->prontuarioRepository->groupByArea($areaId);
    }

    public function getProntuariosPorTipoDocumento(?int $areaId = null)
    {
        return $this->prontuarioRepository->groupByDocumentType($areaId);
    }

    public function getTramitesPorMes(?int $areaId = null)
    {
        return $this->prontuarioRepository->groupByMonth($areaId);
    }

    public function getDistinctYears()
    {
        return $this->prontuarioRepository->getDistinctYears();
    }

    public function resetProntuario()
    {
        return $this->prontuarioRepository->resetProntuario();
    }

    public function getMaxNumberForContext(?int $workerId, $giroType, int $docTypeId)
    {
        return $this->prontuarioRepository->getMaxNumberForContext($workerId, $giroType, $docTypeId);
    }

    public function getCmLinealesByDocTypeAndPeriod($startDate, $endDate)
    {
        $prontuarios = $this->prontuarioRepository->getCmLinealesByDocTypeAndPeriod($startDate, $endDate);
        $groupedByDocType = $prontuarios->groupBy('doc_type_id');

        $cmLinealesPerDocType = $groupedByDocType->map(function ($items) {
            $totalFolios = $items->sum('folios');
            $totalCmLineales = ($totalFolios / 200) * 5;
            return $totalCmLineales;
        });

        $cmLinealesReport = [];
        foreach ($cmLinealesPerDocType as $docTypeId => $cmLineales) {
            $docType = $this->docTypeRepository->getById($docTypeId);
            $cmLinealesReport[] = ['doc_type' => $docType ? $docType->description : 'Desconocido', 'cm_lineales' => $cmLineales];
        }
        return $cmLinealesReport;
    }

    public function getProntuarioPdfPath($id): array
    {
        $prontuario = $this->getById($id);

        if (!$prontuario) {
            throw new \Exception('Prontuario no encontrado.');
        }

        $attachment = Attachment::where('prontuario_id', $prontuario->id)->first();

        if (!$attachment || !Storage::disk('public')->exists($attachment->file_path)) {
            throw new \Exception('Archivo PDF no encontrado.');
        }

        $path = storage_path('app/public/' . $attachment->signed_file_path);

        return [
            'path' => $path,
            'filename' => $attachment->file_name
        ];
    }

    public function getExternalWithSignatureStatus(?bool $signed = null, string $orderBy = 'number', string $direction = 'desc')
    {
        return $this->prontuarioRepository->getExternalWithSignatureStatus($signed, $orderBy, $direction);
    }

}
