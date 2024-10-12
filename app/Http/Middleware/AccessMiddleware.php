<?php

namespace App\Http\Middleware;

use App\Models\Supervisor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (isset($request->user()->id) && (!Auth::user()->is_admin) && (Auth::user()->id != $request->user()->id)) {
        $subordinates_id = Supervisor::where('supervisor_id', Auth::user()->id)->pluck('user_id');
            if(!in_array(Auth::user()->id, $subordinates_id->toArray()))
                return back()->with('error', 'Accès non autorisé.');
        }
        // if ($request->service() && !Auth::user()->is_admin) {
        //     // return redirect()->route('home')->with('error', 'Accès non autorisé.');
        //     if(Auth::user()->service_id != $request->service->id){
        //         return back()->with('error', 'Accès non autorisé.');
        //     }
        // }
        // if ($request->role() && !Auth::user()->is_admin) {
        //     // return redirect()->route('home')->with('error', 'Accès non autorisé.');
        //     return back()->with('error', 'Accès non autorisé.');
        // }
        // if ($request->contrat() && !Auth::user()->is_admin) {
        //     // return redirect()->route('home')->with('error', 'Accès non autorisé.');
        //     return back()->with('error', 'Accès non autorisé.');
        // }
        return $next($request);
    }

}
