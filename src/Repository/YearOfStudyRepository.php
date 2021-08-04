<?php

namespace App\Repository;

use App\Entity\YearOfStudy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method YearOfStudy|null find($id, $lockMode = null, $lockVersion = null)
 * @method YearOfStudy|null findOneBy(array $criteria, array $orderBy = null)
 * @method YearOfStudy[]    findAll()
 * @method YearOfStudy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class YearOfStudyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, YearOfStudy::class);
    }

    // /**
    //  * @return YearOfStudy[] Returns an array of YearOfStudy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('y.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?YearOfStudy
    {
        return $this->createQueryBuilder('y')
            ->andWhere('y.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
