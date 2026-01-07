<?php

namespace App\Http\Controllers;

use App\Http\Requests\prontuario\CreateProntuarioRequest;
use App\Http\Requests\prontuario\DeleteProntuarioRequest;
use App\Http\Requests\prontuario\EditProntuarioRequest;
use App\Http\Requests\prontuario\EstablishInitNumberRequest;
use App\Http\Requests\prontuario\UploadFileRequest;
use App\Repositories\AreaRepository;
use App\Repositories\DocTypeRepository;
use App\Repositories\GiroTypeRepository;
use App\Repositories\GroupRepository;
use App\Repositories\ProntuarioInitialNumberRepository;
use App\Repositories\WorkerRepository;
use App\Services\AttachmentService;
use App\Services\ProntuarioService;
use App\Services\SystemService;
use Illuminate\Support\Facades\Auth;

class ProntuarioController extends Controller
{

    protected ProntuarioService $prontuarioService;
    protected AreaRepository $areaRepository;
    protected GroupRepository $groupRepository;
    protected DocTypeRepository $docTypeRepository;
    protected GiroTypeRepository $giroTypeRepository;
    protected WorkerRepository $workerRepository;
    protected ProntuarioInitialNumberRepository $prontuarioInitialNumberRepository;
    protected SystemService $systemService;
    
    public function __construct(ProntuarioService $prontuarioService, AreaRepository $areaRepository, GroupRepository $groupRepository, DocTypeRepository $docTypeRepository, GiroTypeRepository $giroTypeRepository, WorkerRepository $workerRepository, ProntuarioInitialNumberRepository $prontuarioInitialNumberRepository, SystemService $systemService)
    {
        $this->prontuarioService = $prontuarioService;
        $this->areaRepository = $areaRepository;
        $this->groupRepository = $groupRepository;
        $this->docTypeRepository = $docTypeRepository;
        $this->giroTypeRepository = $giroTypeRepository;
        $this->workerRepository = $workerRepository;
        $this->prontuarioInitialNumberRepository = $prontuarioInitialNumberRepository;
        $this->systemService = $systemService;
    }
 
    public function index( $slug)
    {
        $giroType = $this->giroTypeRepository->findBy('slug', $slug)->firstOrFail();

        $conditions = ['giro_type_id' => $giroType->id];
        $prontuarios = $this->prontuarioService->getProntuariosByFields($conditions, ['worker.subGroup', 'worker.group', 'worker.group.area', 'attachment']);
        $selectedOption = $giroType->slug;
        return view("prontuario.prontuario", compact("prontuarios", "selectedOption"));
    }

    public function create()
    {
        $data = $this->prontuarioService->getDataFormCreation();
        return view('prontuario.create-prontuario', $data);
    }

    public function createByType($slug)
    {
        $data = $this->prontuarioService->getDataWorkerFormCreation($slug);
        
        switch($slug)
        {
            case 'internos': return view('prontuario.create-intern-prontuario', $data, compact('slug'));
            case 'externos': return view('prontuario.create-extern-prontuario', $data, compact('slug'));
            case 'publicos': return view('prontuario.create-public-prontuario', $data, compact('slug'));
            case 'entre-equipos': return view('prontuario.create-entre-grupos-prontuario', $data, compact('slug'));
            case 'personales': return view('prontuario.create-personal-prontuario', $data, compact('slug'));
        }
    }

    public function store(CreateProntuarioRequest $request)
    {
        try {
            $worker = Auth::user()->worker;
            $role = Auth::user()->role;
            $prontuario = $this->prontuarioService->create($request->validated(), $worker->id);
            
            if ($role === 'ADMIN') {
                return redirect()->route('prontuario', $prontuario->giroType->slug)->with('created', 'Register created');
            }

            return redirect()->route('prontuario.show', [$prontuario->giroType->slug, $worker->id])
                ->with('created', [
                    'message' => 'Número Generado',
                    'area' => $prontuario->area?->description,
                    'group_type' => $prontuario->group?->areaGroupType?->groupType?->description,
                    'group' => $prontuario->group?->description,
                    'subgroup' => $prontuario->subgroup?->description,
                    'entity' => $prontuario->entity?->description,
                    'publictype' => $prontuario->publicType?->description,
                    'document' => $prontuario->docType->description,
                    'number' => $prontuario->number,
                    'date' => $prontuario->date,
                ]);
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
    public function show($slug, $id)
    {
        $prontuario = $this->prontuarioService->getByIdWithRelations($id, ['docType', 'attachment', 'area', 'group', 'subgroup', 'entity', 'publicType']);
        if (!$prontuario) {
            return redirect()->back()->with('error', 'Número no encontrado.');
        }
        return view('prontuario.show-prontuario', compact('prontuario', 'slug'));
    }

    public function showByType(string $slug, int $workerId)
    {
        $giroType = $this->giroTypeRepository->findBy('slug', $slug)->firstOrFail();

        $conditions = [
            'worker_id' => $workerId,
            'giro_type_id' => $giroType->id,
        ];
        
        $prontuarios = $this->prontuarioService->getProntuariosByFields($conditions, ['attachment']);
        return view('user.procedure', compact('prontuarios', 'giroType'));
    }

    public function edit(int $id)
    {
        $prontuario = $this->prontuarioService->getById($id);

        if (!$prontuario) {
            return redirect()->route('prontuario', 'internos')->with('error', 'El registro no existe.');
        }

        $data = $this->prontuarioService->getDataFormCreation();
        return view('prontuario.edit-prontuario', [
            'prontuario' => $prontuario,
            'selectedEntityId' => $prontuario->entity_id ?? null,
            'selectedTipoPublicoId' =>$prontuario->public_type_id ?? null,
            'selectedAreaId' => $prontuario->area_id ?? null,
            'selectedTipoGrupoId' => $prontuario->group->groupType?->id ?? null,
            'selectedGrupoId' => $prontuario->group_id ?? null,
            'selectedSubgrupoId' => $prontuario->subgroup_id ?? null,
            'selectedGiroType' => $prontuario->giroType->slug,
            'areaResponsibleWorker' => $prontuario->worker->group->area->id,
            'areas' => $data['areas'],
            'giros' => $data['giros'],
            'doc_types' => $data['doc_types'],
            'entities' => $data['entities'],
            'public_types' => $data['public_types'],
        ]);
    }

    public function update(EditProntuarioRequest $request, int $id)
    {
        try {
            $prontuario = $this->prontuarioService->updateProntuario($id, $request->all());
            return redirect()->route('prontuario', $prontuario->giroType->slug)
                            ->with('success', 'Registro actualizado exitosamente.');
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return redirect()->route('prontuario', $prontuario->giroType->slug)->with('error', 'Ocurrió un error inesperado.');
        }
    }

    public function destroy(DeleteProntuarioRequest $request, int $id)
    {
        $prontuario = $this->prontuarioService->getById($id);

        if ($prontuario) {

            $prontuario->update([
                'approved' => false,
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Registro desaprobado exitosamente.');
        }
        return back()->with('error', 'Registro no encontrado.');
    }

    public function askReset()
    {
        return view("prontuario.reset-prontuario");
    }

    public function reset(){
        $this->prontuarioInitialNumberRepository->resetInitialNumbers();
        $this->prontuarioService->resetProntuario();
        return redirect()->route('prontuario.ask')->with('success', 'Prontuario reiniciado exitosamente.');
    }

    public function initialNumbers()
    {
        $giroTypes = $this->giroTypeRepository->getActives();

        $areas = $this->areaRepository->getActives();
        $intern_doc_types = $this->docTypeRepository->getByGiroType('internos');
        $extern_doc_types = $this->docTypeRepository->getByGiroType('externos');
        $public_doc_types = $this->docTypeRepository->getByGiroType('publicos');
        $group_doc_types = $this->docTypeRepository->getByGiroType('entre-equipos');
        $personal_doc_types = $this->docTypeRepository->getByGiroType('personales');
        $groups = $this->groupRepository->getActives();
        $workers = $this->workerRepository->getAll();

        $initialNumbers = $this->prontuarioInitialNumberRepository->getInitialNumbers();        

        return view("prontuario.initial-number-prontuario", compact([
            'areas',
            'intern_doc_types',
            'extern_doc_types',
            'public_doc_types',
            'group_doc_types',
            'personal_doc_types',
            'groups',
            'workers',
            'initialNumbers',
            'giroTypes',
        ]));
    }

    public function storeInitialNumber(EstablishInitNumberRequest $request)
    {
        $giroType = $this->giroTypeRepository->getById($request->tipo_giro);

        if(!$giroType)
        {
            return back()->with('error', 'Derivación no encontrada.');
        }

        $doc_type_id = match ($giroType->slug) {
            'internos' => $request->input('intern_document'),
            'externos' => $request->input('extern_document'),
            'publicos' => $request->input('public_document'),
            'entre-equipos' => $request->input('groups_document'),
            'personales' => $request->input('personal_document'),
            default => null,
        };

        $area_id = $request->area_interno ?? $request->area_publico;
        $group_id = $request->grupo;
        $worker_id = $request->worker_id;

        $result = $this->prontuarioInitialNumberRepository->storeOrUpdateInitialNumber(
            $giroType->id, 
            $doc_type_id,
            $request->numero_inicial,
            $area_id,
            $group_id,
            $worker_id
        );

        return redirect()->route('prontuario.initial.numbers')
            ->with('success', $result['updated'] ? 'Número inicial actualizado exitosamente.' : 'Número inicial establecido exitosamente.');
    }

    public function viewProntuarioPdf($id)
    {
        try {
            $data = $this->prontuarioService->getProntuarioPdfPath($id);

            return response()->file($data['path'], [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $data['filename'] . '"'
            ]);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function cleanAll()
    {
        return view("reset.reset-system");
    }

    public function resetAll()
    {
        try {
            $this->systemService->resetEverything();
            return redirect()->route('dashboard.admin')->with('success', 'Sistema reestablecido exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.admin')->with('error', 'Error al reiniciar: ' . $e->getMessage());
        }
    }

    public function uploadFile(UploadFileRequest $request, $id, AttachmentService $attachmentService)
    {
        try {
            $file = $request->file('file');
            $prontuario = $this->prontuarioService->getById($id);

            if ($prontuario) {
                $attachmentService->storePdf($file, $prontuario->id);
                return redirect()->back()->with('success', 'Archivo subido correctamente.');
            }
            return back()->with('error', 'Registro no encontrado.');
            
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al subir el archivo: ' . $e->getMessage());
        }
    }

    public function deleteFile($id, AttachmentService $attachmentService)
    {
        try {
            $prontuario = $this->prontuarioService->getById($id);

            if (!$prontuario) {
                return back()->with('error', 'Registro no encontrado.');
            }

            $attachment = $prontuario->attachment;

            if (!$attachment) {
                return back()->with('error', 'No se encontró el archivo asociado.');
            }

            if ($attachment->is_signed) {
                return back()->with('error', 'No puedes eliminar un documento firmado.');
            }

            $attachmentService->deleteAttachment($prontuario);

            return redirect()->back()->with('success', 'Documento eliminado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}