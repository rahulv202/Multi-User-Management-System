<?php

namespace App\Middleware;

use App\Core\Response;

class AuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        // Check if the user is not logged in 
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page
            Response::redirect('/login');
            return;
        }

        // Proceed to the next middleware/controller
        return $next($request);
    }
}
