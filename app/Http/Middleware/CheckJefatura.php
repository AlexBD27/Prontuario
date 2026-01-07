<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJefatura
{

    public function handle($request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isJefatura()) {
            
            // Aquí puedes decidir a dónde redirigir
            if (auth()->user()->role === 'ADMIN') {
                return redirect()
                    ->route('dashboard.admin')
                    ->with('error', 'No tienes permiso para firmar documentos.');
            } elseif (auth()->user()->role === 'USER') {
                return redirect()
                    ->route('dashboard.user')
                    ->with('error', 'No tienes permiso para firmar documentos.');
            }

            // Si no quieres diferenciar roles, solo regresa atrás
            return redirect()
                ->back()
                ->with('error', 'No tienes permiso para firmar documentos.');
        }

        return $next($request);
    }


}
