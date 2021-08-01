<?php

namespace App\Repository;

use App\Entity\GradeCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GradeCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method GradeCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method GradeCategory[]    findAll()
 * @method GradeCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GradeCategoryRepository extends ServiceEntityRepository
{

    public function findGrades($classesId)
    {
        $qb = $this-> createQueryBuilder('gc');

        $qb
            -> select('gc.category_name', 'g.grade', 'st.id' , 'st.firstname', 'st.lastname', 's.subject_name', 'sg.group_name')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'gc= g.category')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= g.classes')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= s')
            -> innerJoin('App\Entity\Student','st',\Doctrine\ORM\Query\Expr\Join::WITH,'g.student= st')
            -> innerJoin('App\Entity\Sgroup','sg',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group= sg')
            -> where($qb->expr()->eq('c.id',$classesId));


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    public function findFinalGrades($classesId, $final)
    {
        $qb = $this-> createQueryBuilder('gc');

        $qb
            -> select( 'g.grade', 'st.id' , 'st.firstname', 'st.lastname', 's.subject_name', 'sg.group_name')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'gc= g.category')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= g.classes')
            -> innerJoin('App\Entity\Subject','s',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= s')
            -> innerJoin('App\Entity\Student','st',\Doctrine\ORM\Query\Expr\Join::WITH,'g.student= st')
            -> innerJoin('App\Entity\Sgroup','sg',\Doctrine\ORM\Query\Expr\Join::WITH,'s.group= sg')
            -> where($qb->expr()->eq('c.id',$classesId))
            -> andWhere('gc.category_name LIKE :searchTerm')
            -> setParameter('searchTerm', '%'.$final.'%');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    public function findGradeCategory($classesId)
    {
        $qb = $this-> createQueryBuilder('gc');

        $qb
            -> select('gc.category_name')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c= gc.classes')
            -> where($qb->expr()->eq('gc.classes',$classesId));


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }



    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GradeCategory::class);
    }

    // /**
    //  * @return GradeCategory[] Returns an array of GradeCategory objects
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
    public function findOneBySomeField($value): ?GradeCategory
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
