<?php

namespace Source\Http\Middleware;

use Source\Support\Csrf;

use Respect\Validation\Validator;

/**
 * Class CsrfMiddleware
 * 
 * @package Source\Http\Middleware
 */
class CsrfMiddleware
{
    /**
     * @return bool
     */
    public function handle(): bool
    {
        if (Validator::identical($_SERVER['REQUEST_METHOD'])->validate('POST')) {
            if (!(new Csrf)->validate()) {
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
