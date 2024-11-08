<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddAcceptEncodingHeader
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Menambahkan header 'Accept-Encoding'
        $response->header('Accept-Encoding', 'gzip, deflate, br');

        return $response;
    }
}
