<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\DataFixtures\BaseFixtures;
use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];

    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];

    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article, $count)  use ($manager) {
            $article
                ->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent('some test content' . rand(100, 9999))
                ->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            if ($this->faker->boolean(70)) { // 70% chance to be true
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $comment1 = new Comment();
            $comment1->setAuthorName('Mike Ferengi');
            $comment1->setContent('Asteroids cooment rocks!');
            //$comment1->setArticle($article);

            $comment2 = new Comment();
            $comment2->setAuthorName('John Doe');
            $comment2->setContent('Second comment content');
            //$comment2->setArticle($article);


            $manager->persist($comment1);
            $manager->persist($comment2);

            // no matter, before or after persist
            $article->addComment($comment1);
            $article->addComment($comment2);
        });

        $manager->flush();
    }
}
