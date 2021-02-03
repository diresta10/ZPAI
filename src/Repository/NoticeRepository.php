<?php

namespace App\Repository;

use App\Entity\Notice;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notice[]    findAll()
 * @method Notice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoticeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notice::class);
    }

    public function findPublishedNotice()
    {
        $qb = $this-> createQueryBuilder('n');

        $qb
            -> select('n.title', 'n.body','n.created', 't.firstname', 't.lastname')
            -> innerJoin('App\Entity\Teacher','t',\Doctrine\ORM\Query\Expr\Join::WITH,'t = n.teacher_id')
            -> orderBy('n.created', 'DESC')
            ->setMaxResults(4);

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }


    public function findMyNotice($userId)
    {
        $qb = $this-> createQueryBuilder('n');

        $qb
            -> select('n.title', 'n.body')
            -> where($qb->expr()->eq('n.teacher_id',$userId))
            -> orderBy('n.created', 'DESC');

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    // /**
    //  * @return Notice[] Returns an array of Notice objects
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
    public function findOneBySomeField($value): ?Notice
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
