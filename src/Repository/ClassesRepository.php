<?php

namespace App\Repository;

use App\Entity\Classes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Classes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Classes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Classes[]    findAll()
 * @method Classes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classes::class);
    }

    public function findClasses($groupId, $subjectId)
    {
        $qb = $this-> createQueryBuilder('c');

        $qb
            -> select('c.id')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= s')
            -> innerJoin('App\Entity\Sgroup','sg',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group= sg')
            -> where($qb->expr()->eq('c.subject',$subjectId), $qb->expr()->eq('s.group',$groupId))
            -> distinct('c.id');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    // /**
    //  * @return Classes[] Returns an array of Classes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Classes
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
