<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error',
                'status_code' => 401,
                'result' => null,
                'message' => 'Token ไม่ถูกต้องหรือไม่ระบุ',
            ], 200);
        }

        $allowedRoles = explode('|', $roles);

        $userRole = Auth::user()->role->role_name;

        if (!in_array($userRole, $allowedRoles)) {
            return response()->json([
                'status' => 'error',
                'status_code' => 403,
                'result' => null,
                'message' => 'สิทธิ์การเข้าถึงไม่เพียงพอ (Role: ' . $userRole . ')',
            ], 200);
        }

        return $next($request);
    }
}
