<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Student) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findStudentInfo($studentId)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('s.firstname', 's.lastname','s.email', 's.image', 'a.street_address', 'a.locality', 'a.postal_code')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> innerJoin('App\Entity\Address','a',\Doctrine\ORM\Query\Expr\Join::WITH,'a = s.address');

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findAllStudents($gid)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('s.firstname', 's.lastname' ,'s.email', 'g.group_name', 's.image', 's.id')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group')
            -> where($qb->expr()->eq('g.id',$gid));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }

    public function findStudentsByGroup($sid)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('s.firstname', 's.lastname' ,'s.email', 's.id', 'g.group_name', 'sub.subject_name', 'gr.grade')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.group = s.group')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'sub = c.subject')
            -> innerJoin('App\Entity\Grade','gr',\Doctrine\ORM\Query\Expr\Join::WITH,'gr.student = s')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g = c.group')
            -> where($qb->expr()->eq('sub.id',$sid));

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findStudentToDownload($tid)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('s.firstname', 's.lastname' ,'s.email', 'g.group_name', 's.id')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.group = g')
            -> innerJoin('App\Entity\Teacher','t',\Doctrine\ORM\Query\Expr\Join::WITH,'c.teacher = t')
            -> where($qb->expr()->eq('t.id',$tid))
            -> distinct('s.id')
            -> orderBy('g.group_name', 'ASC');

        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }


    // /**
    //  * @return Student[] Returns an array of Student objects
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
    public function findOneBySomeField($value): ?Student
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
