<?php

use Source\Http\Middleware\AuthMiddleware as Auth;
use Source\Http\Middleware\CsrfMiddleware as Csrf;

use CoffeeCode\Router\Router;

/*
|--------------------------------------------------------------------------
| Router Start
|--------------------------------------------------------------------------
*/

$router = new Router(url());

/*
|--------------------------------------------------------------------------
| Router Web
|--------------------------------------------------------------------------
*/

$router->namespace('Source\Http\Controllers\Web');

$router->group(null);
$router->get('/', 'WebController:index', 'web.home');

/*
|--------------------------------------------------------------------------
| Router Api
|--------------------------------------------------------------------------
*/

$router->namespace('Source\Http\Controllers\Api\v1');

$router->group('api/v1', [Auth::class, Csrf::class]);
$router->post('/comment/create', 'CommentController:create', 'comment.create');
$router->post('/comment/delete', 'CommentController:delete', 'comment.delete');
$router->post('/comment/update', 'CommentController:update', 'comment.update');

/*
|--------------------------------------------------------------------------
| Router End
|--------------------------------------------------------------------------
*/

$router->dispatch();

/*
|--------------------------------------------------------------------------
| Router Error
|--------------------------------------------------------------------------
*/

if ($router->error()) {
    http_response_code($router->error());

    echo json_encode([
        'status_type' => 'Bad Request',
        'status_message' => 'There was a problem with your request',
        'status' => false
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
