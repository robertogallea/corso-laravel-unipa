<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkingHours
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // posso accedere all'applicazione solo fra le 9 e le 18
        if ((now()->hour > 18) || (now()->hour < 9)) {
            abort(Response::HTTP_FORBIDDEN, 'L\'applicazione può essere utilizzata solo in orario lavorativo');
        }

        return $next($request);
    }
}
