<?php

namespace App\Http\Controllers;

use App\Http\Requests\doctype\CreateDocumentRequest;
use App\Http\Requests\doctype\EditDocumentRequest;
use App\Repositories\DocTypeRepository;
use App\Repositories\GiroTypeRepository;

class DocTypeController extends Controller
{

    protected DocTypeRepository $docTypeRepository;
    protected GiroTypeRepository $giroTypeRepository;

    public function __construct(DocTypeRepository $docTypeRepository, GiroTypeRepository $giroTypeRepository){
        $this->docTypeRepository = $docTypeRepository;
        $this->giroTypeRepository = $giroTypeRepository;
    }

    public function index()
    {
        $doc_types = $this->docTypeRepository->getAll();
        return view("doctypes.index-doctype", compact("doc_types"));
    }

    public function create()
    {
        $giroTypes = $this->giroTypeRepository->getActives();
        return view("doctypes.create-doctype", compact('giroTypes'));
    }

    public function store(CreateDocumentRequest $request)
    {
        $docType = $this->docTypeRepository->create($request->only('abbreviation', 'description'));

        if ($request->has('giro_types')) {
            $docType->giroTypes()->sync($request->input('giro_types'));
        }

        return redirect()->route("doctype")->with("success","Documento creado exitosamente.");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(int $id)
    {
        $doc_type = $this->docTypeRepository->getById($id);
        $giroTypes = $this->giroTypeRepository->getActives();

        if (!$doc_type) {
            return redirect()->route('doctype')->with('error', 'El tipo de documento no existe.');
        }

        return view("doctypes.edit-doctype", compact("doc_type", "giroTypes"));
    }

    public function update(EditDocumentRequest $request, int $id)
    {
        $doc_type = $this->docTypeRepository->getById($id);
        if($doc_type)
        {
            $data = $request->only(['abbreviation', 'description', 'active']);
            $updated = $this->docTypeRepository->updateDocType($id, $data);

            if ($request->has('giro_types')) {
                $doc_type->giroTypes()->sync($request->input('giro_types'));
            } else {
                $doc_type->giroTypes()->sync([]);
            }

            if ($updated) {
                return redirect()->route('doctype')->with('success', 'Documento actualizado exitosamente.');
            }
        }     
        return redirect()->route('doctype')->with('error', 'Documento no encontrado.');
    }

    public function destroy(int $id)
    {
        if($this->docTypeRepository->delete($id))
        {
            return redirect()->route('doctype')->with('success', 'Documento eliminado exitosamente.');
        }    
        return redirect()->route('doctype')->with('error', 'Documento no encontrado.'); 
    }
}
