<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = session('role');
        
        if (!in_array($userRole, $roles)) {
            return redirect()->route('daftarKegiatan')
                ->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
        
        return $next($request);
    }
}
