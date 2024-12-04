<?php

namespace App\Middleware;

// use App\Core\Response;
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;
use App\Utils\JWTUtil;
use App\Models\User;

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
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (strpos($authHeader, 'Bearer ') !== 0) {
            http_response_code(401);
            echo json_encode(['message' => 'Unauthorized']);
            return;
        }

        $token = substr($authHeader, 7);

        try {
            // Decode token and verify logout time
            $decoded = $this->jwtUtil->verify($token, null);

            $userModel = new User();
            $logoutTime = $userModel->getLogoutTime($decoded->id);
            $this->jwtUtil->verify($token, $logoutTime);
            $request['user'] = $decoded;
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => $e->getMessage()]);
            return;
        }

        return $next($request);
    }
}
