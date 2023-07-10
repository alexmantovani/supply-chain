<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class WarehouseIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::user()->activeWarehouse) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            abort(403, 'Impossibile accedere al portale senza avere un magazzino di riferimento assegnato');
        }
        return $next($request);
    }
}
