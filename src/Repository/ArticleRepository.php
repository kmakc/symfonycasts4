<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
    * @return Article[] Returns an array of Article objects
    */
    public function findAllPublishedOrderByNewest()
    {
        // reuse example
       /* $this->createQueryBuilder('a')
            ->addCriteria(self::createNonDeletedCriteria());*/

        return $this->addIsPublishedQueryBuilder()
            ->orderBy('article.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    private function addIsPublishedQueryBuilder(QueryBuilder $qb = null)
    {
        return $this
            ->getOrCreateQueryBuilder()
            ->andWhere('article.publishedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('article');
    }

    public static function createNonDeletedCriteria(): Criteria
    {
        return  Criteria::create()
            ->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC']);
    }
}
