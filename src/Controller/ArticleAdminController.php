<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();

        $article
            ->setTitle('test title')
            ->setSlug('test-slug-' . rand(100, 9999))
            ->setContent('some test content');

        if (rand(1, 10) > 2) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }

        $em->persist($article);
        $em->flush();

        return new Response(sprintf(
            'article was saved: #%d, slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}
