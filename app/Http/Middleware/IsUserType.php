<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // get the data parameters
        $types = array_slice(func_get_args(), 2);
        $index = array_search(Auth::user()->type, $types);
        // dd($type);

        if (Auth::user()->type != $types[$index]) {
            return back();
        }

        // else return
        return $next($request);
    }
}
