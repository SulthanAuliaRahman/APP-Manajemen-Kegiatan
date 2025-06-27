<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $userRole = session('role');
        Log::info('CheckRole middleware: User Role - ' . ($userRole ?? 'Not set') . ', Required Roles: ' . implode(', ', $roles));

        if (!session()->has('user_id') || !in_array($userRole, $roles)) {
            return redirect()->route('daftarKegiatan')
                ->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
        
        return $next($request);
    }
}
