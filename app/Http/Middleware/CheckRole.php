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
        Log::info('CheckRole middleware: User Role - ' . ($userRole ?? 'Not set') . ', All Raw Roles Passed: ' . json_encode($roles));

        // Combine and clean all roles passed
        $allowedRoles = array_reduce($roles, function ($carry, $role) {
            return array_merge($carry, array_filter(explode(',', str_replace('role:', '', $role))));
        }, []);

        Log::info('CheckRole middleware: Processed Allowed Roles: ' . json_encode($allowedRoles));

        if (!session()->has('user_id') || empty($allowedRoles) || !in_array($userRole, $allowedRoles)) {
            Log::info('Redirecting due to unauthorized role. User Role: ' . ($userRole ?? 'Not set') . ', Allowed Roles: ' . json_encode($allowedRoles));
            return redirect()->route('daftarKegiatan')
                ->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
        
        return $next($request);
    }
}
