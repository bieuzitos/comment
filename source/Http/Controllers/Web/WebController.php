<?php

namespace Source\Http\Controllers\Web;

use Source\Http\Controllers\Controller;

use Source\Models\UserAccount;
use Source\Models\UserComment;

/**
 * Class WebController
 * 
 * @package Source\Http\Controllers\Web
 */
class WebController extends Controller
{
    /**
     * @param object|string $router
     * 
     * @return void
     */
    public function __construct(object|string $router)
    {
        parent::__construct($router);
    }

    /**
     * @return void
     */
    public function index(): void
    {
        $optimizer = $this->seo->render(
            'Comentários' . SITE_TITLE,
            SITE_DESC,
            $this->router->route('web.home')
        );

        echo $this->view->render('home/index', [
            'seo' => $optimizer,

            'comments' => (new UserComment())->getAllByContent(1),
            'comments_count' => (new UserComment())->getCountByContent(1)
        ]);
    }
}
