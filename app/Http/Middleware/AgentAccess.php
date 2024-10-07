<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AgentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::user())
            return to_route('login')->with('danger',"Veuillez vous connecter.");

        // if(in_array(Auth::user()->role, array("owner","visitor")))
        //     return to_route('auth.login')->with('danger',"Vous n'avez pas l'autorisation.");

        return $next($request);
    }
}
