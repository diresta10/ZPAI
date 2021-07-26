<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

    public function findFiles($tid)
    {
        $qb = $this-> createQueryBuilder('f');

        $qb
            -> select('f.id','f.filename', 'f.created', 's.subject_name', 'sg.group_name')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= f.classes')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= s')
            -> innerJoin('App\Entity\Sgroup','sg',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group= sg')
            -> where($qb->expr()->eq('c.teacher',$tid));


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    // /**
    //  * @return File[] Returns an array of File objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?File
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
