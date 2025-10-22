<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowMessage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!session()->has('message_shown')) {
            $response->setContent($response->getContent() . '<script>alert("Messaggio avviso")</script>');
            session()->put('message_shown', true);
            session()->save();
        }

        return $response;
    }

    public function terminate(Request $request, Response $response)
    {
        // codice eseguito dopo l'invio della response al browser
    }
}
