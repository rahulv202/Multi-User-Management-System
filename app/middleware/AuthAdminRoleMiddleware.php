<?php

namespace App\Middleware;

use App\Core\Response;

class AuthAdminRoleMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        if ($_SESSION['role'] == 'Admin') {
            return $next($request);
        }
        // Redirect to login page
        Response::redirect('/dashboard');
    }
}
