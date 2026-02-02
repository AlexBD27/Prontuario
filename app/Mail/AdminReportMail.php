<?php

namespace App\Mail;

use App\Models\GeneratedReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class AdminReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public GeneratedReport $report;

    public function __construct(GeneratedReport $report)
    {
        $this->report = $report;
    }

    public function build()
    {
        return $this->subject('Reporte generado')
            ->view('emails.admin-report')
            ->attach(
                Storage::disk('private')->path($this->report->file_path),
                [
                    'as'   => $this->report->file_name,
                    'mime' => 'application/pdf',
                ]
            );
    }
}
