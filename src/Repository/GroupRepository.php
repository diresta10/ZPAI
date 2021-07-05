<?php

namespace App\Repository;

use App\Entity\Sgroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * @method Sgroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sgroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sgroup[]    findAll()
 * @method Sgroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sgroup::class);
    }

    public function findGroupsBySubject($sid)
    {
        $qb = $this-> createQueryBuilder('g');

        $qb
            -> select('g.group_name')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group = g')
            -> where($qb->expr()->eq('s.id',$sid));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }






}
