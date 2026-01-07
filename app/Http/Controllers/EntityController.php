<?php

namespace App\Http\Controllers;

use App\Http\Requests\entity\CreateEntityRequest;
use App\Http\Requests\entity\EditEntityRequest;
use App\Repositories\EntityRepository;

class EntityController extends Controller
{

    protected EntityRepository $entityRepository;

    public function __construct(EntityRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    public function index()
    {
        $entities = $this->entityRepository->getAll();
        return view('entities.index-entity', compact('entities'));
    }

    public function create()
    {
        return view('entities.create-entity');
    }

    public function store(CreateEntityRequest $request)
    {
        $this->entityRepository->create($request->all());
        return redirect()->route('entity')->with('success', 'Entidad creada exitosamente.');
    }

    public function show(int $id)
    {
        //
    }

    public function edit(int $id)
    {
        $entity = $this->entityRepository->getById($id);

        if (!$entity) {
            return redirect()->route('entity')->with('error', 'La entidad no existe.');
        }

        return view('entities.edit-entity', compact('entity'));
    }

    public function update(EditEntityRequest $request, int $id)
    {
        $entity = $this->entityRepository->getById($id);
        if($entity)
        {
            $data = $request->only(['abbreviation', 'description', 'active']);
            $updated = $this->entityRepository->updateDocType($id, $data);
            if ($updated) {
                return redirect()->route('entity')->with('success', 'Entidad actualizada exitosamente.');
            }
        }     
        return redirect()->route('entity')->with('error', 'Entidad no encontrada.');
    }

    public function destroy(int $id)
    {
        if($this->entityRepository->delete($id))
        {
            return redirect()->route('entity')->with('success', 'Entidad eliminada exitosamente.');
        }    
        return redirect()->route('entity')->with('error', 'Entidad no encontrada.'); 
    }
}
