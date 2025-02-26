<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;
use Auth;

class IfAlumni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Role::where('id', auth()->user()->role_id)->first();
            if ($role && in_array($role->id, [5, 6])) {
                return $next($request);
            }
        }
        return redirect(url('/'));
    }
}
