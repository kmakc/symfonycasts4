<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\DataFixtures\BaseFixtures;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article, $count){
            $article
                ->setTitle('test title'. rand(100, 9999))
                ->setSlug('test-slug-' . $count)
                ->setContent('some test content' . rand(100, 9999))
                ->setAuthor('authorTest' . rand(100, 9999))
                ->setHeartCount(rand(1,100))
                ->setImageFilename('asteroid.jpeg');

            if (rand(1, 10) > 2) {
                $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
            }
        });

        $manager->flush();
    }
}
