<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Doctrine\ORM\EntityRepository;
/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findPaginatedArticles(Country $country){

        // Create our query
        $query = $this->createQueryBuilder('p')
            ->orderBy('p.created_at', 'DESC')
            ->andWhere('a.country = :country')
            ->getQuery();

        // No need to manually get get the result ($query->getResult())
        $pages = $this->paginate($query, $country);
        return $pages;

    }


  /*   public function findArticlesByCountry(Country $country){

        $query = $this->createQueryBuilder('a')
            ->orderBy('a.created_at', 'DESC')
            ->andWhere('a.country = :country')
            ->getQuery()
            ->getResult();


    } */



    private function paginate($dql, $page = 1, $limit = 6)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult( ($page - 1) * $limit) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function findLastFourArticles(){
        return $this->createQueryBuilder('a')
            ->orderBy('a.created_at', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

  



    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
