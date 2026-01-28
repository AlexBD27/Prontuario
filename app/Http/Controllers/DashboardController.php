<?php

namespace App\Http\Controllers;

use App\Repositories\GiroTypeRepository;
use App\Services\ProntuarioService;

class DashboardController extends Controller
{

    protected ProntuarioService $prontuarioService;
    protected GiroTypeRepository $giroTypeRepository;

    public function __construct(ProntuarioService $prontuarioService, GiroTypeRepository $giroTypeRepository)
    {
        $this->prontuarioService = $prontuarioService;
        $this->giroTypeRepository = $giroTypeRepository;
    }

    public function user()
    {
        $areaId = auth()->user()->worker->group->area->id;
        $workerId = auth()->user()->worker->id;
        return $this->getDashboardData($areaId, $workerId);
    }

    public function admin()
    {
        return $this->getDashboardData();
    }

    private function getDashboardData(int $areaId = null, int $workerId = null)
    {
        // $giroInterno = $this->giroTypeRepository->findBy('slug', 'internos')->first();
        // $giroExterno = $this->giroTypeRepository->findBy('slug', 'externos')->first();
        // $giroPublico = $this->giroTypeRepository->findBy('slug', 'publicos')->first();
        // $giroGrupos = $this->giroTypeRepository->findBy('slug', 'entre-equipos')->first();
        // $giroPersonal = $this->giroTypeRepository->findBy('slug', 'personales')->first();

        // $totalInternos = $this->prontuarioService->getTotalByField('giro_type_id', $giroInterno->id, $areaId);
        // $totalExternos = $this->prontuarioService->getTotalByField('giro_type_id', $giroExterno->id, $areaId);
        // $totalPublicos = $this->prontuarioService->getTotalByField('giro_type_id', $giroPublico->id, $areaId) ?? 0;
        // $totalEquipos = $this->prontuarioService->getTotalByField('giro_type_id', $giroGrupos->id, $areaId);
        // $totalPersonal = $this->prontuarioService->getTotalByField('giro_type_id', $giroPersonal->id, $areaId, $workerId);


        $slugs = ['internos', 'externos', 'publicos', 'entre-equipos', 'personales'];
        $giros = collect($slugs)->mapWithKeys(function ($slug) {
            return [$slug => $this->giroTypeRepository->findBy('slug', $slug)->first()];
        });

        $totalInternos  = $this->prontuarioService->getTotalByField('giro_type_id', $giros['internos']?->id, $areaId) ?? 0;
        $totalExternos  = $this->prontuarioService->getTotalByField('giro_type_id', $giros['externos']?->id, $areaId) ?? 0;
        $totalPublicos  = $this->prontuarioService->getTotalByField('giro_type_id', $giros['publicos']?->id, $areaId) ?? 0;
        $totalEquipos   = $this->prontuarioService->getTotalByField('giro_type_id', $giros['entre-equipos']?->id, $areaId) ?? 0;
        $totalPersonal  = $this->prontuarioService->getTotalByField('giro_type_id', $giros['personales']?->id, $areaId, $workerId) ?? 0;


        $totalProntuarios = $this->prontuarioService->getAll()->count();

        $conditionsPeriodoApproved = [
            'period' => now()->year,
            'approved' => 1
        ];

        $conditionsPeriodoDisapproved = [
            'period' => now()->year,
            'approved' => 0
        ];

        //$totalPeriodo = $this->prontuarioService->getTotalByField('period', now()->year, $areaId);
        $totalPeriodoApproved = $this->prontuarioService->getTotalByFields($conditionsPeriodoApproved, $areaId);
        $totalPeriodoDisapproved = $this->prontuarioService->getTotalByFields($conditionsPeriodoDisapproved, $areaId);

        $prontuariosPorArea = $this->prontuarioService->getProntuariosPorArea($areaId);
        $prontuariosPorTipoDocumento = $this->prontuarioService->getProntuariosPorTipoDocumento($areaId);
        $tramitesPorMes = $this->prontuarioService->getTramitesPorMes($areaId);

        return view('dashboard', compact(
            'totalProntuarios',
            'totalInternos',
            'totalExternos',
            'totalPublicos',
            'totalPeriodoApproved',
            'totalPeriodoDisapproved',
            'totalEquipos',
            'totalPersonal',
            'prontuariosPorArea',
            'prontuariosPorTipoDocumento',
            'tramitesPorMes'
        ));
    }

}
