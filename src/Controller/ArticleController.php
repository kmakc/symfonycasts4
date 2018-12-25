<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
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
        $comments = [
            'First comment',
            'Second comment',
            'Third comment',
        ];

        return $this->render('article/show.html.twig', [
            'title'    => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);
    }
}
