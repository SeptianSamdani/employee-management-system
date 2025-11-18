<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if (!$request->user()->hasPermissionTo($permission)) {
            abort(403, 'Anda tidak memiliki permission.');
        }

        return $next($request);
    }
}