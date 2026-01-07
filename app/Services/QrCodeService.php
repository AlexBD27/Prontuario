<?php

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use setasign\Fpdi\Fpdi;

class QrCodeService
{

    public function generateQrTempFile(int $prontuarioId): string
    {
        $url = route('prontuario.view', ['id' => $prontuarioId]);

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $pngPath = "{$tempDir}/qr_{$prontuarioId}.png";

        $builder = new Builder(new PngWriter());

        $result = $builder->build(
            null,     // WriterInterface|null -> si es null usa el writer pasado en el constructor (PngWriter)
            null,     // writerOptions
            null,     // validateResult
            $url,     // data (el texto o URL que se codifica)
            null,     // encoding
            null,     // errorCorrectionLevel
            200,      // size
            10        // margin
        );

        $result->saveToFile($pngPath);

        return $pngPath;
    }


    public function addQrFooter(Fpdi $pdf, string $qrPath, int $prontuarioId, float $pageWidth, float $pageHeight)
    {
        $boxHeight = 18; // Altura de la zona del footer
        $qrSize = 20;    // Tamaño del QR

        // Posición en Y (parte inferior, con margen de seguridad de 2.5 mm)
        $boxY = $pageHeight - $boxHeight - 2.5;

        // Evitar salto automático
        $pdf->SetAutoPageBreak(false);

        // QR pegado al borde izquierdo (2 mm de margen nada más)
        $qrX = 2;
        $qrY = $boxY + ($boxHeight - $qrSize) / 2;
        $pdf->Image($qrPath, $qrX, $qrY, $qrSize, $qrSize);

        // Texto a la derecha del QR
        $textX = $qrX + $qrSize + 5; // un pequeño espacio después del QR
        $textWidth = ($pageWidth / 2); 
        // ocupa hasta la mitad de la hoja

        $pdf->SetXY($textX, $boxY + 2);
        $pdf->SetFont('Arial', '', 7.0);
        $pdf->SetTextColor(50, 50, 50);

        $url = route('prontuario.view', ['id' => $prontuarioId]);

        $text = utf8_decode("Esto es una copia auténtica imprimible de un documento electrónico archivado en la UGEL Santa, aplicando lo dispuesto en el Art. 25 de D.S. 070-2013-PCM y la tercera Disposición Complementaria Final del D.S. 026-2016-PCM. Su autenticidad e integridad puede ser contrastadas a través de la siguiente dirección WEB: $url");

        $pdf->MultiCell($textWidth, 3.5, $text);

        $pdf->SetAutoPageBreak(true, 15);
    }


}