<?php

namespace App\Http\Controllers;

use App\Http\Requests\prontuario\UploadFileRequest;
use App\Services\AttachmentService;
use App\Services\ProntuarioService;

class SignatureController extends Controller
{

    protected ProntuarioService $prontuarioService;
    
    public function __construct(ProntuarioService $prontuarioService)
    {
        $this->prontuarioService = $prontuarioService;
    }

    public function signed()
    {
        $prontuarios = $this->prontuarioService->getExternalWithSignatureStatus(true);
        return view('prontuario.signature-index', [
            'prontuarios' => $prontuarios,
            'isJefatura'  => auth()->user()->isJefatura(),
            'from' => 'signed'
        ]);
    }

    public function unsigned()
    {
        $prontuarios = $this->prontuarioService->getExternalWithSignatureStatus(false);
        return view('prontuario.signature-index', [
            'prontuarios' => $prontuarios,
            'isJefatura'  => auth()->user()->isJefatura(),
            'from' => 'unsigned'
        ]);
    }

    public function show($slug, $id, $from)
    {
        $prontuario = $this->prontuarioService->getByIdWithRelations($id, ['docType', 'attachment', 'area', 'group', 'subgroup', 'entity', 'publicType', 'worker.group.area', 'worker.subGroup']);
        if (!$prontuario) {
            return redirect()->back()->with('error', 'Número no encontrado.');
        }
        return view('prontuario.signature-show', compact('prontuario', 'slug', 'from'));
    }

    public function store(UploadFileRequest $request, $id, AttachmentService $attachmentService)
    {
        try {
            $file = $request->file('file');
            $prontuario = $this->prontuarioService->getById($id);

            if ($prontuario) {
                $attachmentService->storeSignedPdf($file, $prontuario);
                return redirect()->back()->with('success', 'Archivo firmado subido correctamente.');
            }
            return back()->with('error', 'Registro no encontrado.');
            
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Ocurrió un error al subir el archivo: ' . $e->getMessage());
        }
    }

    public function delete($id, AttachmentService $attachmentService)
    {
        try {
            $prontuario = $this->prontuarioService->getById($id);

            if (!$prontuario) {
                return back()->with('error', 'Registro no encontrado.');
            }

            $attachment = $prontuario->attachment;

            if (!$attachment || !$attachment->signed_file_path) {
                return back()->with('error', 'No se encontró un archivo firmado asociado.');
            }

            $attachmentService->deleteSignedAttachment($attachment);

            return redirect()->back()->with('success', 'Documento firmado eliminado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}
