<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);

        // handle only when post request, loads data to form from request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$data = $form->getData();
            $article = $form->getData();

           /* $article = new Article();
            $article->setTitle($data['title']);
            $article->setContent($data['content']);*/

            //$article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article created successful!');

            return $this->redirectToRoute('admin_article_list');
        }

        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/{id}/edit", name="admin_article_edit")
     */
    public function edit(Article $article, Request $request, EntityManagerInterface $em)
    {
        // $this->denyAccessUnlessGranted('MANAGE', $article);
        // or in annotation: * @isGranted("MANAGE", subject="article")

        /*if (!$this->isGranted('MANAGE', $article)) {
            throw $this->createAccessDeniedException('No access');
        }

        dd($article);*/

        $form = $this->createForm(ArticleFormType::class, $article, [
            'include_published_at' => true
        ]);

        // handle only when post request, loads data to form from request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //$data = $form->getData();
            //$article = $form->getData();

            /* $article = new Article();
             $article->setTitle($data['title']);
             $article->setContent($data['content']);*/

            //$article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article updated successful!');

            return $this->redirectToRoute('admin_article_edit', [
                'id' => $article->getId(),
            ]);
        }

        return $this->render('article_admin/edit.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     *  @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('article_admin/list.html.twig', [
            'articles' => $articles,
        ]);
    }
}
