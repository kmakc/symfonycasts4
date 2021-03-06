<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\MarkdownHelper;
use App\Helper\LoggerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    use LoggerTrait;

    /**
     * @var bool
     */
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, CommentRepository $commentRepository)
    {
        // В данном случае можно не делать $article->getComments(),
        // а прямо в Twig получать доступ к комментам так: article.comments
        //$comments = $commentRepository->findBy(['article' => $article]); // not lazy load
        $comments = $article->getNonDeletedComments(); // lazy load

        return $this->render('article/show.html.twig', [
            'article'  => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        $em->flush();

        $logger->info('Article is being hearted');
        $this->logInfo('Log frm trait', [
            'message' => 'test'
        ]);

        return new JsonResponse(['hearts' => $article->getHeartCount()]); // or return $this->json(['hearts' => rand(5, 100)]);
    }
}
