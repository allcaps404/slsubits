<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventMobileAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the request is coming from a mobile device
        if ($this->isMobile($request->header('User -Agent'))) {
            // Redirect to a different page or show an error message
            return response()->view('errors.mobile', [], 403); // You can create a mobile.blade.php view for this
        }

        return $next($request);
    }

    /**
     * Check if the User-Agent is from a mobile device.
     *
     * @param string $userAgent
     * @return bool
     */
    protected function isMobile($userAgent)
    {
        return preg_match('/Mobile|Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i', $userAgent);
    }
}