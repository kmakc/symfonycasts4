<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/hello/{slug}", name="article_show")
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
            'slug'     => $slug,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/hello/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug)
    {
        // TODO - actually heart/unheart the article

        return new JsonResponse(['hearts' => rand(5, 100)]); // or return $this->json(['hearts' => rand(5, 100)]);
    }
}
