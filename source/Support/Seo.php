<?php

namespace Source\Support;

use CoffeeCode\Optimizer\Optimizer;

/**
 * Class Seo
 * 
 * @package Source\Support
 */
class Seo
{
    /** @var Optimizer */
    protected $optimizer;

    /**
     * @param string $schema
     * 
     * @return void
     */
    public function __construct(string $schema = 'article')
    {
        $this->optimizer = new Optimizer();
        $this->optimizer->openGraph(
            SITE_NAME,
            SITE_LOCALE,
            $schema
        );
    }

    /**
     * @param string $title
     * @param string $description
     * @param string $url
     * @param string $image
     * @param bool $follow
     * 
     * @return string
     */
    public function render(string $title, string $description, string $url, string $image = '', bool $follow = true): string
    {
        return $this->optimizer->optimize(
            $title,
            $description,
            $url,
            $image,
            $follow
        )->render();
    }
}
