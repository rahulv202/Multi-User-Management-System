<?php

namespace App\Middleware;

// use App\Core\Response;
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;
use App\Utils\JWTUtil;

class ApiAuthMiddleware implements MiddlewareInterface
{
    // public function handle($request, $next)
    // {
    //     $headers = getallheaders();

    //     // Check for Authorization header
    //     if (!isset($headers['Authorization'])) {
    //         return Response::json(['error' => 'Unauthorized'], 401);
    //     }

    //     $token = str_replace('Bearer ', '', $headers['Authorization']);

    //     try {
    //         // Decode JWT (use your secret key)
    //         $decoded = JWT::decode($token, new Key(CONFIG['jwt_secret'], 'HS256'));
    //         $request['user'] = $decoded; // Attach decoded user to the request
    //     } catch (\Exception $e) {
    //         return Response::json(['error' => 'Invalid token'], 401);
    //     }

    //     // Proceed to the next middleware/controller
    //     return $next($request);
    // }
    private $jwtUtil;
    public function __construct($jwtConfig)
    {
        $this->jwtUtil = new JWTUtil($jwtConfig);
    }

    public function handle($request, $next)
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Authorization token is required.']);
            return;
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $user = $this->jwtUtil->validateToken($token);

        if (!$user) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token.']);
            return;
        }

        $request['user'] = $user; // Pass the decoded user to the next middleware or controller
        return $next($request);
    }
}
