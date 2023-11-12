<?php

namespace Source\Http\Controllers;

use Source\Support\Message;
use Source\Support\Seo;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use League\Plates\Extension\Asset;

/**
 * Class Controller
 * 
 * @package Source\Http\Controllers
 */
class Controller
{
    /** @var Router */
    protected $router;

    /** @var View */
    protected $view;

    /** @var Message */
    protected $message;

    /** @var Seo */
    protected $seo;

    /**
     * @param object|string $router
     * @param string $pathToViews
     * @param string $fileExtension
     * 
     * @return void
     */
    public function __construct(object|string $router, string $fileExtension = 'php')
    {
        $this->router = $router;

        $this->view = (new Engine(dirname(__DIR__, 3) . '/resources/views', $fileExtension));
        $this->view->loadExtension(new Asset(dirname(__DIR__, 3) . '/public/', true));
        $this->view->addData(['router' => $this->router]);

        $this->message = new Message();
        $this->seo = new Seo();
    }
}
