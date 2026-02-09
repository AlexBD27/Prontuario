<?php

namespace App\Http\Controllers;

use App\Exports\AdminExcelExport;
use App\Exports\AdminExcelExportByWorker;
use App\Exports\LinealCmExport;
use App\Exports\WorkerExcelExport;
use App\Mail\AdminReportMail;
use App\Repositories\AreaRepository;
use App\Repositories\DocTypeRepository;
use App\Repositories\GiroTypeRepository;
use App\Repositories\WorkerRepository;
use App\Services\ProntuarioService;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mail;

class PDFGeneratorController extends Controller
{

    protected ProntuarioService $prontuarioService;
    protected AreaRepository $areaRepository;
    protected WorkerRepository $workerRepository;
    protected GiroTypeRepository $giroTypeRepository;
    protected DocTypeRepository $docTypeRepository;
    
    public function __construct(ProntuarioService $prontuarioService, AreaRepository $areaRepository, WorkerRepository $workerRepository, GiroTypeRepository $giroTypeRepository, DocTypeRepository $docTypeRepository)
    {
        $this->prontuarioService = $prontuarioService;
        $this->areaRepository = $areaRepository;
        $this->workerRepository = $workerRepository;
        $this->giroTypeRepository = $giroTypeRepository;
        $this->docTypeRepository = $docTypeRepository;
    }

    public function index()
    {
        $years = $this->prontuarioService->getDistinctYears();
        $girotypes = $this->giroTypeRepository->getAll();
        $doctypes = $this->docTypeRepository->getAll();

        if(Auth::user()->role === 'ADMIN')
        {
            $areas = $this->areaRepository->getAreasWithRelations(['groupTypes.areaGroupTypes.groups.workers']);
            $workers = $this->workerRepository->getAll();

            return view('reports.admin.index-report', compact('years', 'workers', 'areas', 'doctypes', 'girotypes'));
        }else{
            return view('reports.user.index-report', compact('years', 'girotypes', 'doctypes'));
        }
    }

    public function generateByWorker($id, Request $request)
    {
        $prontuarios = $this->getWorkerProntuarios($id, $request);
        $pdf = Pdf::loadView('reports.user.my-numbers', ['prontuario' => $prontuarios])->setPaper('a4', 'landscape');
        return $pdf->download('reporte-trabajador.pdf');
    }

    public function exportByWorker($id, Request $request)
    {
        $prontuarios = $this->getWorkerProntuarios($id, $request);    
        return Excel::download(new WorkerExcelExport($prontuarios), 'reporte-trabajador.xlsx');
    }

    public function generateAdminReports(Request $request)
    {
        $pdf = $this->buildAdminReportPdf($request);

        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="reporte_admin.pdf"',
        ]);
    }

    private function buildAdminReportPdf(Request $request)
    {
        $reportType = $request->input('report_type');
        $startDate  = Carbon::parse($request->input('start_date'))->format('d/m/Y');
        $endDate    = Carbon::parse($request->input('end_date'))->format('d/m/Y');

        $prontuarios = $this->getAdminProntuarios($request);

        switch ($reportType) {
            case 'lineal_cm':
                return Pdf::loadView(
                    'reports.admin.lineal-cm',
                    compact('prontuarios', 'startDate', 'endDate')
                );

            case 'worker':
            case 'custom':
                $groupedProntuarios = $prontuarios;
                return Pdf::loadView(
                    'reports.admin.worker-report',
                    compact('groupedProntuarios')
                )->setPaper('a4', 'landscape');

            default:
                return Pdf::loadView(
                    'reports.admin.all-report',
                    ['prontuario' => $prontuarios]
                )->setPaper('a4', 'landscape');
        }
    }



    // public function generateAdminReports(Request $request)
    // {
    //     $reportType = $request->input('report_type');
    //     $startDate = Carbon::parse($request->input('start_date'))->format('d/m/Y');
    //     $endDate = Carbon::parse($request->input('end_date'))->format('d/m/Y');
    //     $prontuarios = $this->getAdminProntuarios($request);

    //     $fileName = 'reporte_admin_' . now()->format('Ymd_His') . '.pdf';
    //     $filePath = 'reports/admin/' . $fileName;

    //     if($reportType === 'all')
    //     {
    //         $pdf = Pdf::loadView('reports.admin.all-report', ['prontuario' => $prontuarios])->setPaper('a4', 'landscape');
    //     }
    //     if($reportType === 'all_actual_period')
    //     {
    //         $pdf = Pdf::loadView('reports.admin.all-report', ['prontuario' => $prontuarios])->setPaper('a4', 'landscape');
    //     }
    //     if($reportType === 'doctype')
    //     {
    //         $pdf = Pdf::loadView('reports.admin.all-report', ['prontuario' => $prontuarios])->setPaper('a4', 'landscape');
    //     }
    //     if($reportType === 'derivation')
    //     {
    //         $pdf = Pdf::loadView('reports.admin.all-report', ['prontuario' => $prontuarios])->setPaper('a4', 'landscape');
    //     }
    //     if($reportType === 'lineal_cm')
    //     {
    //         $pdf = PDF::loadView('reports.admin.lineal-cm', compact('prontuarios', 'startDate', 'endDate'));
    //     }
    //     if($reportType === 'worker')
    //     {
    //         $groupedProntuarios = $prontuarios;
    //         $pdf = Pdf::loadView('reports.admin.worker-report', compact('groupedProntuarios'))->setPaper('a4', 'landscape');
    //     }
    //     if($reportType === 'custom')
    //     {
    //         $groupedProntuarios = $prontuarios;
    //         $pdf = Pdf::loadView('reports.admin.worker-report', compact('groupedProntuarios'))->setPaper('a4', 'landscape');
    //     }

    //     $directory = 'reports/admin';

    //     if (!Storage::exists($directory)) {
    //         Storage::makeDirectory($directory);
    //     }

    //     Storage::put($filePath, $pdf->output());

    //     return response()->file(
    //         Storage::path($filePath),
    //         [
    //             'Content-Type' => 'application/pdf',
    //             'Content-Disposition' => 'inline; filename="'.$fileName.'"'
    //         ]
    //     );
    
    // }


    public function sendAdminReportEmail(Request $request)
    {
        $request->validate([
            'email'   => 'required|email',
            'filters'=> 'required|array'
        ]);

        $pdf = $this->buildAdminReportPdf(
            new Request($request->filters)
        );

        Mail::to($request->email)->send(
            new AdminReportMail($pdf->output())
        );

        return response()->json(['ok' => true]);
    }



    public function exportByAdmin(Request $request)
    {
        $reportType = $request->input('report_type');
        $prontuarios = $this->getAdminProntuarios($request);

        if($reportType === 'all')
        {
            return Excel::download(new AdminExcelExport($prontuarios), 'reporte-admin-all.xlsx');
        }
        if($reportType === 'all_actual_period')
        {
            return Excel::download(new AdminExcelExport($prontuarios), 'reporte-admin-actual-period.xlsx');
        }
        if($reportType === 'doctype')
        {
            return Excel::download(new AdminExcelExport($prontuarios), 'reporte-admin-by-document.xlsx');
        }
        if($reportType === 'derivation')
        {
            return Excel::download(new AdminExcelExport($prontuarios), 'reporte-admin-by-derivation.xlsx');
        }
        if($reportType === 'lineal_cm')
        {
            $startDate = Carbon::parse($request->input('start_date'))->format('d/m/Y');
            $endDate = Carbon::parse($request->input('end_date'))->format('d/m/Y');
            return Excel::download(new LinealCmExport($prontuarios, $startDate, $endDate), 'reporte-lineal-cm.xlsx');
        }
        if($reportType === 'worker')
        {
            $groupedProntuarios = $prontuarios;
            return Excel::download(new AdminExcelExportByWorker($groupedProntuarios), 'reporte-admin-by-worker.xlsx');
        }
        if($reportType === 'custom')
        {
            $groupedProntuarios = $prontuarios;
            return Excel::download(new AdminExcelExportByWorker($groupedProntuarios), 'reporte-admin-custom.xlsx');
        }
    }


    private function getWorkerProntuarios($id, Request $request)
    {
        $reportType = $request->input('report_type');
        $prontuarios = collect();
        $derivation = (int) $request->input('derivation_type');
        $doctype = (int) $request->input('document_type');

        if ($reportType === 'all')
        {
            $prontuarios = $this->prontuarioService->getProntuariosByWorkerActualPeriod($id);
        }
        else if($reportType === 'doctype')
        {
            $prontuarios = $this->prontuarioService->getProntuariosByWorkerDoctypeActualPeriod($id, $doctype);
        }
        else if($reportType === 'custom')
        {
            $year = $request->input('period');
            $months = $request->input('months', []);
            $prontuarios = $this->prontuarioService->getProntuariosByWorkerCustomFields($id, $year, $months, $derivation, $doctype);
        } 
        else if($reportType === 'derivation')
        {
            $prontuarios = $this->prontuarioService->getProntuariosByWorkerDerivationActualPeriod($id, $derivation);
        }

        return $prontuarios;
    }

    private function getAdminProntuarios(Request $request)
    {
        $reportType = $request->input('report_type');
        $areaId = (int) $request->input('area');
        $tipoGroupId = (int) $request->input('tipo_grupo');
        $groupId = (int) $request->input('grupo');
        $id = (int) $request->input('worker');
        $doctype = (int) $request->input('document_type');
        $derivation = (int) $request->input('derivation_type');
        $year = $request->input('worker_period');
        $months = $request->input('months', []);

        if($reportType === 'all')
        {
            return $this->prontuarioService->getAll();
        }
        if($reportType === 'all_actual_period')
        {
            return $this->prontuarioService->getTotalByActualPeriod();
        }
        if($reportType === 'doctype')
        {
            return $this->prontuarioService->getProntuariosByFieldActualPeriod('doc_type_id', $doctype);
        }
        if($reportType === 'derivation')
        {
            return $this->prontuarioService->getProntuariosByFieldActualPeriod('giro_type_id', $derivation);
        }
        if($reportType === 'lineal_cm')
        {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);
    
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            return $this->prontuarioService->getCmLinealesByDocTypeAndPeriod($startDate, $endDate);
        }
        
        if($reportType === 'worker')
        {
            $prontuarios = $this->prontuarioService->getProntuariosAdminCustomFields($areaId, $tipoGroupId, $groupId, $id, $year, $months);
            
            $groupedProntuarios = $prontuarios->groupBy(function ($prontuario) {
                return $prontuario->worker->group->area->description ?? 'Sin Área';
            })->map(function ($areaGroup) {
                return $areaGroup->groupBy(function ($prontuario) {
                    return $prontuario->worker->group->description ?? 'Sin Grupo';
                })->map(function ($groupGroup) {
                    return $groupGroup->groupBy(function ($prontuario) {
                        return $prontuario->worker->name ?? 'Sin Trabajador';
                    });
                });
            });

            return $groupedProntuarios;
        }

        if($reportType === 'custom')
        {
            $prontuarios = $this->prontuarioService->getProntuariosAdminCustomFields($areaId, $tipoGroupId, $groupId, $id, $year, $months, $derivation, $doctype);
            
            $groupedProntuarios = $prontuarios->groupBy(function ($prontuario) {
                return $prontuario->worker->group->area->description ?? 'Sin Área';
            })->map(function ($areaGroup) {
                return $areaGroup->groupBy(function ($prontuario) {
                    return $prontuario->worker->group->description ?? 'Sin Grupo';
                })->map(function ($groupGroup) {
                    return $groupGroup->groupBy(function ($prontuario) {
                        return $prontuario->worker->name ?? 'Sin Trabajador';
                    });
                });
            });

            return $groupedProntuarios;
        }
    }
}