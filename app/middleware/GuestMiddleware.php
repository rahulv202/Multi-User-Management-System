<?php

namespace App\Middleware;

use App\Core\Response;

class GuestMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        //check if the user is logged in
        if (isset($_SESSION['user_id'])) {
            // Redirect to Dashboard page
            Response::redirect('/dashboard');
            return;
        }

        // Proceed to the next middleware/controller
        return $next($request);
    }
}
