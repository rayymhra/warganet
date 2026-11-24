<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class CheckRole {
    public function handle(Request $request, Closure $next, string $role) {
        abort_unless($request->user() && $request->user()->role === $role, 403, 'Access denied.');
        return $next($request);
    }
}