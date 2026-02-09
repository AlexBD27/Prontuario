<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private string $pdfContent) {}

    public function build()
    {
        return $this->subject('Reporte generado')
            ->view('emails.admin-report')
            ->attachData($this->pdfContent, 'reporte.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
