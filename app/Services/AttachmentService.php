<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use App\Models\Attachment;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class AttachmentService
{

    public function storePdf(UploadedFile $file, int $prontuarioId)
    {
        if ($file->getClientOriginalExtension() !== 'pdf') {
            throw new \Exception('Solo se permiten archivos PDF.');
        }

        $originalName = $file->getClientOriginalName();
        $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = Str::slug($nameOnly) ?: 'documento';
        $fileName = "{$prontuarioId}_{$sanitizedName}.{$extension}";

        $finalPath = $file->storeAs('uploads', $fileName, 'public');

        return Attachment::create([
            'file_name' => $fileName,
            'file_path' => $finalPath,
            'prontuario_id' => $prontuarioId,
            'is_signed' => 0
        ]);
    }

    public function storeSignedPdf(UploadedFile $file, $prontuario)
    {
        if ($file->getMimeType() !== 'application/pdf') {
            throw new \Exception('Solo se permiten archivos PDF.');
        }

        $originalName = $file->getClientOriginalName();
        $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = Str::slug($nameOnly) ?: 'documento';
        $fileName = "{$prontuario->id}_{$sanitizedName}.{$extension}";
        $signedFileName = "signed_{$prontuario->id}_{$sanitizedName}.{$extension}";

        // Generar QR
        $qrService = new QrCodeService();
        $qrPath = $qrService->generateQrTempFile($prontuario->id);

        try {
            $pdf = new Fpdi();
            $pageCount = $pdf->setSourceFile($file->getRealPath());

            for ($i = 1; $i <= $pageCount; $i++) {
                $tplIdx = $pdf->importPage($i);
                $size = $pdf->getTemplateSize(tpl: $tplIdx);

                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($tplIdx);

                $qrService->addQrFooter($pdf, $qrPath, $prontuario->id, $size['width'], $size['height']);
            }

            // Ruta absoluta de la carpeta firmados
            $signedDir = storage_path("app/public/uploads/firmados");

            // Crear carpeta si no existe
            if (!file_exists($signedDir)) {
                mkdir($signedDir, 0755, true);
            }

            // Guardar PDF final
            $finalPath = "{$signedDir}/{$signedFileName}";
            $pdf->Output($finalPath, 'F');

            //guardar
            $attachment = $prontuario->attachment;

            if ($attachment) {
                $attachment->signed_file_path = "uploads/firmados/{$signedFileName}";
                $attachment->is_signed = 1;
                $attachment->save();
            } else {
                $originalFilePath  = $file->storeAs('uploads', $fileName, 'public');
                
                $attachment = new Attachment();
                $attachment->file_name = $fileName;
                $attachment->file_path = $originalFilePath;
                $attachment->prontuario_id = $prontuario->id;
                $attachment->signed_file_path = "uploads/firmados/{$signedFileName}";
                $attachment->is_signed = 1;
                $attachment->save();
            }

        } finally {
            if (file_exists($qrPath)) {
                unlink($qrPath);
            }
        }
    }




    // public function storePdf(UploadedFile $file, int $prontuarioId)
    // {
    //     if ($file->getClientOriginalExtension() !== 'pdf') {
    //         throw new \Exception('Solo se permiten archivos PDF.');
    //     }

    //     $originalName = $file->getClientOriginalName();
    //     $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
    //     $extension = $file->getClientOriginalExtension();
    //     $sanitizedName = Str::slug($nameOnly);
    //     $fileName = "{$prontuarioId}_{$sanitizedName}.{$extension}";

    //     $qrService = new QrCodeService();
    //     $qrPath = $qrService->generateQrTempFile($prontuarioId);

    //     try {
    //         $pdf = new Fpdi();

    //         $pageCount = $pdf->setSourceFile($file->getRealPath());

    //         for ($i = 1; $i <= $pageCount; $i++) {
    //             $tplIdx = $pdf->importPage($i);
    //             $size = $pdf->getTemplateSize($tplIdx);

    //             $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
    //             $pdf->useTemplate($tplIdx);

    //             $qrService->addQrFooter($pdf, $qrPath, $prontuarioId, $size['width'], $size['height']);
    //         }

    //         $finalPath = storage_path("app/public/uploads/{$fileName}");
    //         $pdf->Output($finalPath, 'F');



    //         return Attachment::create([
    //             'file_name' => $fileName,
    //             'file_path' => "uploads/{$fileName}",
    //             'prontuario_id' => $prontuarioId,
    //         ]);
    //     } catch (\Throwable $e) {
    //         throw new \Exception("Error al procesar el PDF: " . $e->getMessage());
    //     } finally {
    //         if (file_exists($qrPath)) {
    //             unlink($qrPath);
    //         }
    //     }
    // }

    public function deleteAttachment($prontuario): void
    {
        if (!$prontuario->attachment) {
            return;
        }
        Storage::disk('public')->delete($prontuario->attachment->file_path);

        $prontuario->attachment()->delete();
    }

    public function deleteSignedAttachment($attachment): void
    {
        if (!$attachment->signed_file_path) {
            return;
        }

        Storage::disk('public')->delete($attachment->signed_file_path);

        $attachment->signed_file_path = null;
        $attachment->is_signed = 0;
        $attachment->save();
    }



}