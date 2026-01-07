<?php

namespace App\Http\Controllers;

use App\Http\Requests\girotype\CreateGiroTypeRequest;
use App\Http\Requests\girotype\EditGiroTypeRequest;
use App\Repositories\GiroTypeRepository;

class GiroTypeController extends Controller
{

    protected GiroTypeRepository $giroTypeRepository;

    public function __construct(GiroTypeRepository $giroTypeRepository){
        $this->giroTypeRepository = $giroTypeRepository;
    }

    public function index()
    {
        $giro_types = $this->giroTypeRepository->getAll();
        return view('girotypes.index-girotype', compact('giro_types'));
    }

    public function create()
    {
        return view('girotypes.create-girotype');
    }

    public function store(CreateGiroTypeRequest $request)
    {
        $this->giroTypeRepository->create($request->all());
        return redirect()->route("girotype")->with("success","Derivación creada exitosamente.");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(int $id)
    {
        $giro_type = $this->giroTypeRepository->getById($id);

        if (!$giro_type) {
            return redirect()->route('girotype')->with('error', 'La derivación no existe.');
        }

        return view("girotypes.edit-girotype", compact("giro_type"));
    }

    public function update(EditGiroTypeRequest $request, int $id)
    {
        $giro_type = $this->giroTypeRepository->getById($id);
        if($giro_type)
        {
            $data = $request->only(['abbreviation', 'description', 'active']);
            $updated = $this->giroTypeRepository->updateGiroType($id, $data);
            if ($updated) {
                return redirect()->route('girotype')->with('success', 'Derivación actualizada exitosamente.');
            }
        }     
        return redirect()->route('girotype')->with('error', 'Derivación no encontrada.');
    }

    public function destroy(int $id)
    {
        if($this->giroTypeRepository->delete($id))
        {
            return redirect()->route('girotype')->with('success', 'Derivación eliminada exitosamente.');
        }    
        return redirect()->route('girotype')->with('error', 'Derivación no encontrada.');
    }
}
