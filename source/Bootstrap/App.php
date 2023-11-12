<?php

/*
|--------------------------------------------------------------------------
| Helpers
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/Helpers/Helper.php';
require_once __DIR__ . '/Helpers/Session.php';

/*
|--------------------------------------------------------------------------
| Minify
|--------------------------------------------------------------------------
*/

if (is_localhost()) {
    require_once __DIR__ . '/Minify/Web.php';
}

/*
|--------------------------------------------------------------------------
| Application Locale Configuration
|--------------------------------------------------------------------------
|
| Idiomas disponíveis: [ pt_BR ]
|
*/

define('SITE_LOCALE', 'pt_BR');

/*
|--------------------------------------------------------------------------
| Application URL
|--------------------------------------------------------------------------
*/

define('URL_TEST', 'https://comment.test');
define('URL_BASE', 'https://www.bieuzitos.com');

/*
|--------------------------------------------------------------------------
| Application Environment
|--------------------------------------------------------------------------
*/

\Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__, 2))->load();

/*
|--------------------------------------------------------------------------
| Application Name
|--------------------------------------------------------------------------
*/

define('SITE_NAME', 'Comment');

/*
|--------------------------------------------------------------------------
| Application Timezone
|--------------------------------------------------------------------------
*/

define('SITE_TIMEZONE', 'America/Sao_Paulo');

/*
|--------------------------------------------------------------------------
| CSRF
|--------------------------------------------------------------------------
*/

define('CSRF_ENABLE', true);

/*
|--------------------------------------------------------------------------
| Comment
|--------------------------------------------------------------------------
*/

define('COMMENT_MAX', 500);

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

define('SITE_TITLE', ' • ' . SITE_NAME);
define('SITE_DESC', 'Plataforma interativa que permite aos usuários efetuar comentários, avaliações e com recursos avançados de respostas.');
define('SITE_DOMAIN', str_replace('https://www.', '', URL_BASE));

/*
|--------------------------------------------------------------------------
| Database Connection
|--------------------------------------------------------------------------
*/

define('DATA_LAYER_CONFIG', [
    'driver' => $_ENV['DB_CONNECTION'],
    'host' => $_ENV['DB_HOST'],
    'port' => $_ENV['DB_PORT'],
    'dbname' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'passwd' => $_ENV['DB_PASSWORD'],
    'options' => [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/

require_once __DIR__ . '/Language/' . SITE_LOCALE . '.php';