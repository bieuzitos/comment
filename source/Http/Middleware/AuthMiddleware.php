<?php

namespace Source\Http\Middleware;

use Respect\Validation\Validator;

/**
 * Class AuthMiddleware
 * 
 * @package Source\Http\Middleware
 */
class AuthMiddleware
{
    /**
     * @return bool
     */
    public function handle(): bool
    {
        if (Validator::identical($_SERVER['REQUEST_METHOD'])->validate('POST')) {
            if (!isLoggedIn()) {
                echo json_encode([
                    'status_message' => MESSAGE_REQUEST_ERROR,
                    'status' => false
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                exit;
            }
        }

        return true;
    }
}
