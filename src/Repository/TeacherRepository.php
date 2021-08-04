<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Teacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Teacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Teacher[]    findAll()
 * @method Teacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Teacher) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findStudentsNumber($tid)
    {
        $qb = $this-> createQueryBuilder('t');

        $qb
            -> select('count(DISTINCT st.id)')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'t = c.teacher')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject = sub')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.group = g')
            -> innerJoin('App\Entity\Student','st',\Doctrine\ORM\Query\Expr\Join::WITH,'st.group = g')
            -> where($qb->expr()->eq('t.id',$tid));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    public function findGroupsNumber($tid)
    {
        $qb = $this-> createQueryBuilder('t');

        $qb
            -> select('count(DISTINCT g.id)')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'t = c.teacher')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject = sub')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.group = g')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study = y')
            -> where($qb->expr()->eq('t.id',$tid),  $qb->expr()->eq('y.isActive','true'));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findSubjectsNumber($tid)
    {
        $qb = $this-> createQueryBuilder('t');

        $qb
            -> select('count(DISTINCT sub.id)')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'t = c.teacher')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject = sub')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.group = g')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study = y')
            -> where($qb->expr()->eq('t.id',$tid),  $qb->expr()->eq('y.isActive','true'));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    // /**
    //  * @return Teacher[] Returns an array of Teacher objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Teacher
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
