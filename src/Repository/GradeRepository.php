<?php

namespace App\Repository;

use App\Entity\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Grade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Grade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Grade[]    findAll()
 * @method Grade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeRepository extends ServiceEntityRepository
{

    public function findClasses($groupId, $subjectId)
    {
        $qb = $this-> createQueryBuilder('g');

        $qb
            -> select('c.id')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= g.classes')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= s')
            -> innerJoin('App\Entity\Sgroup','sg',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group= sg')
            -> where($qb->expr()->eq('c.subject',$subjectId), $qb->expr()->eq('s.group',$groupId))
            -> distinct('c.id');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findGrade($categoryId, $studentId, $classesId)
    {
        $qb = $this-> createQueryBuilder('g');

        $qb
            -> select('g.id')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= g.classes')
            -> innerJoin('App\Entity\GradeCategory','gc',\Doctrine\ORM\Query\Expr\Join::WITH,'g.category = gc')
            -> innerJoin('App\Entity\Student','s',\Doctrine\ORM\Query\Expr\Join::WITH,'g.student = s')
            -> where($qb->expr()->eq('g.student',$studentId), $qb->expr()->eq('g.classes',$classesId), $qb->expr()->eq('g.category',$categoryId));


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }


    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    // /**
    //  * @return Grade[] Returns an array of Grade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grade
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
