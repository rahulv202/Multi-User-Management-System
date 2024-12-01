<?php

namespace App\Middleware;

use App\Core\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiAuthMiddleware implements MiddlewareInterface
{
    public function handle($request, $next)
    {
        $headers = getallheaders();

        // Check for Authorization header
        if (!isset($headers['Authorization'])) {
            return Response::json(['error' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);

        try {
            // Decode JWT (use your secret key)
            $decoded = JWT::decode($token, new Key(SECRET_KEY, 'HS256'));
            $request['user'] = $decoded; // Attach decoded user to the request
        } catch (\Exception $e) {
            return Response::json(['error' => 'Invalid token'], 401);
        }

        // Proceed to the next middleware/controller
        return $next($request);
    }
}
