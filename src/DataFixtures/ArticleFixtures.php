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
        });

        $manager->flush();
    }
}
