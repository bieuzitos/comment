<?php

namespace Source\Http\Controllers\Api;

use Respect\Validation\Validator;

/**
 * Class ApiController
 * 
 * @package Source\Http\Controllers\Api
 */
class ApiController
{
    /** @var array|false */
    protected $headers;

    /** @var array|null */
    protected $response;

    /**
     * @return void
     */
    public function __construct()
    {
        header('Access-Control-Allow-Origin: ' . url());
        header('Content-Type: application/json; charset=UTF-8');

        $this->headers = getallheaders();
    }

    /**
     * @param int $code
     * @param string|null $type
     * @param string|null $message
     * 
     * @return ApiController
     */
    protected function call(int $code, string $type = null, string $message = null, array $additional = []): ApiController
    {
        http_response_code($code);

        $this->response = [
            'status_type' => (Validator::notBlank()->validate($type) ? $type : 'Bad Request'),
            'status_message' => (Validator::notBlank()->validate($message) ? $message : 'There was a problem with your request'),
            'status' => false
        ];

        if (Validator::notBlank()->validate($additional)) {
            $this->response = array_merge($additional, $this->response);
        }

        return $this;
    }

    /**
     * @param array|null $response
     * 
     * @return ApiController
     */
    protected function back(array $response = null): ApiController
    {
        if (!empty($response)) {
            $this->response = (!empty($this->response) ? array_merge($this->response, $response) : $response);
        }

        echo json_encode($this->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        return $this;
    }
}
