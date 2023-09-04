<?php

namespace App\Http\Middleware;

use App\Helpers\BestHelper;
use App\Http\Controllers\TokenController;
use Closure;
use Illuminate\Http\Request;

class AutenticacionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-Authorization') == null) {
            return BestHelper::Data(null, 408, false, 'No existe el token de acceso');
        }
        $token = new TokenController;
        if ($token->checkLogin($request, $code, $message)) {
            return $next($request);
        } else {
            return BestHelper::Data(null, $code, false, $message);
        }
    }
}
