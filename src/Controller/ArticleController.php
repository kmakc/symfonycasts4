<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ArticleController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('First page');
    }

    /**
     * @Route("/hello/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf(
            'This is test page: %s',
            $slug
        ));
    }
}
