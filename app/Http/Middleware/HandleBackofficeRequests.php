<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleBackofficeRequests
{

    public function handle(Request $request, Closure $next): Response
    {
        view()->share('sidebarNavItems',[

        ]);
        return $next($request);
    }
}
