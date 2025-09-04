<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoadEnvironmentVariables
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
        // If you need to load specific environment variables or perform custom logic, you can add it here.

        return $next($request);
    }
}
