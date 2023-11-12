<?php

use MatthiasMullie\Minify\CSS;
use MatthiasMullie\Minify\JS;

$resourcePath = dirname(__DIR__, 3) . '/resources/assets';
$publicPath = dirname(__DIR__, 3) . '/public/assets';

/*
|--------------------------------------------------------------------------
| CSS - STYLES
|--------------------------------------------------------------------------
*/

$CSS = new CSS;
$CSS->add($resourcePath . '/css/_global.css');
$CSS->add($resourcePath . '/css/_styles.css');
$CSS->minify($publicPath . '/css/styles/global.min.css');

/*
|--------------------------------------------------------------------------
| CSS - COMMENT
|--------------------------------------------------------------------------
*/

$CSS = new CSS;
$CSS->add($resourcePath . '/css/comment/form.css');
$CSS->add($resourcePath . '/css/comment/message.css');
$CSS->add($resourcePath . '/css/components/dropdown.css');
$CSS->add($resourcePath . '/css/components/modal.css');
$CSS->add($resourcePath . '/css/components/notification.css');
$CSS->add($resourcePath . '/css/components/textarea.css');
$CSS->minify($publicPath . '/css/styles/comment.min.css');



/*
|--------------------------------------------------------------------------
| JS - MAIN
|--------------------------------------------------------------------------
*/

$JS = new JS;
$JS->add($resourcePath . '/js/main.js');
$JS->minify($publicPath . '/js/scripts/main.min.js');

/*
|--------------------------------------------------------------------------
| JS - NOTIFICATION
|--------------------------------------------------------------------------
*/

$minJS = new JS;
$minJS->add($resourcePath . '/js/notification.js');
$minJS->minify($publicPath . '/js/scripts/notification.min.js');
