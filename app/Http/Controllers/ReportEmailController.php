<?php

namespace App\Http\Controllers;

use App\Mail\AdminReportMail;
use App\Models\GeneratedReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReportEmailController extends Controller
{
    public function send(Request $request, GeneratedReport $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email'
        ]);

        // Mail::to($request->email)
        //     ->send(new AdminReportMail($report));

        try {
            Mail::to($request->email)
                ->send(new AdminReportMail($report));
        } catch (\Exception $e) {
            return back()->withErrors('No se pudo enviar el correo.');
        }


        $report->update(['emailed' => true, 'status' => 'EMAILED']);

        Storage::disk('private')->delete($report->file_path);

        return back()->with('success', 'Reporte enviado correctamente');
    }

    public function discard(GeneratedReport $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        // Eliminar archivo
        Storage::disk('private')->delete($report->file_path);

        $report->update([
            'status' => 'DISCARDED'
        ]);

        return response()->json(['ok' => true]);
    }



}
