<?php

namespace App\Http\Controllers;

use App\Http\Requests\publictype\CreatePublicTypeRequest;
use App\Http\Requests\publictype\EditPublicTypeRequest;
use App\Repositories\PublicTypeRepository;

class PublicTypeController extends Controller
{
    protected PublicTypeRepository $publicTypeRepository;

    public function __construct(PublicTypeRepository $publicTypeRepository)
    {
        $this->publicTypeRepository = $publicTypeRepository;
    }

    public function index()
    {
        $publicTypes = $this->publicTypeRepository->getAll();
        return view('publictypes.index-publictype', compact('publicTypes'));
    }

    public function create()
    {
        return view('publictypes.create-publictype');
    }

    public function store(CreatePublicTypeRequest $request)
    {
        $this->publicTypeRepository->create($request->all());
        return redirect()->route('publictype')->with('success', 'Tipo de público creado exitosamente.');
    }

    public function show(int $id)
    {
        //
    }

    public function edit(int $id)
    {
        $publictype = $this->publicTypeRepository->getById($id);

        if (!$publictype) {
            return redirect()->route('publictype')->with('error', 'El tipo de público no existe.');
        }

        return view('publictypes.edit-publictype', compact('publictype'));
    }

    public function update(EditPublicTypeRequest $request, int $id)
    {
        $publicType = $this->publicTypeRepository->getById($id);
        if($publicType)
        {
            $data = $request->only(['abbreviation', 'description', 'active']);
            $updated = $this->publicTypeRepository->updatePublicType($id, $data);
            if ($updated) {
                return redirect()->route('publictype')->with('success', 'Tipo de público actualizado exitosamente.');
            }
        }     
        return redirect()->route('publictype')->with('error', 'Tipo de público no encontrado.');
    }

    public function destroy(int $id)
    {
        if($this->publicTypeRepository->delete($id))
        {
            return redirect()->route('publictype')->with('success', 'Tipo de público eliminado exitosamente.');
        }    
        return redirect()->route('publictype')->with('error', 'Tipo de público no encontrado.'); 
    }
}
