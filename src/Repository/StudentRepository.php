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
            -> select('s.firstname', 's.lastname','s.email', 's.image', 'a.street_address', 'a.locality', 'a.postal_code', 'g.group_name')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> innerJoin('App\Entity\Address','a',\Doctrine\ORM\Query\Expr\Join::WITH,'a = s.address')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group');

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

    public function findStudentsByClasses($cid)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('s.firstname', 's.lastname' ,'s.email', 's.id')
            -> innerJoin('App\Entity\Sgroup','g',\Doctrine\ORM\Query\Expr\Join::WITH,'g = s.group')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'g = sub.group')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject = sub')
            -> where($qb->expr()->eq('c.id',$cid))
            -> orderBy('s.lastname', 'ASC');

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

    public function findFinalGrades($studentId, $final)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('sub.subject_name', 'g.grade', 'g.date', 'y.year', 't.firstname' , 't.lastname', 'y.start_date', 'y.end_date', 't.title')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'s= g.student')
            -> innerJoin('App\Entity\GradeCategory','gc',\Doctrine\ORM\Query\Expr\Join::WITH,'gc= g.category')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'g.classes= c')
            -> innerJoin('App\Entity\Teacher','t',\Doctrine\ORM\Query\Expr\Join::WITH,'c.teacher= t')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= sub')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study= y')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> andWhere('gc.category_name LIKE :searchTerm')
            -> setParameter('searchTerm', '%'.$final.'%');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findYearOfStudy($studentId)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('y.year', 'y.start_date', 'y.end_date')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'s= g.student')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'g.classes= c')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= sub')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study= y')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> distinct('y.year');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findPartialGrades($studentId, $final)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('g.grade', 'sub.subject_name', 'gc.category_name')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'s= g.student')
            -> innerJoin('App\Entity\GradeCategory','gc',\Doctrine\ORM\Query\Expr\Join::WITH,'gc= g.category')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'g.classes= c')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= sub')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study= y')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> andWhere('gc.category_name NOT LIKE :searchTerm')
            -> setParameter('searchTerm', '%'.$final.'%');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }
    public function findSubjects($studentId)
    {
        $qb = $this-> createQueryBuilder('s');

        $qb
            -> select('sub.subject_name')
            -> innerJoin('App\Entity\Grade','g',\Doctrine\ORM\Query\Expr\Join::WITH,'s= g.student')
            -> innerJoin('App\Entity\Classes','c',\Doctrine\ORM\Query\Expr\Join::WITH,'g.classes= c')
            -> innerJoin('App\Entity\Subject','sub',\Doctrine\ORM\Query\Expr\Join::WITH,'c.subject= sub')
            -> innerJoin('App\Entity\YearOfStudy','y',\Doctrine\ORM\Query\Expr\Join::WITH,'sub.year_of_study= y')
            -> where($qb->expr()->eq('s.id',$studentId))
            -> where($qb->expr()->eq('y.isActive','true'))
            -> distinct('sub.subject_name');


        dump($qb->getQuery()->getResult());

        return $qb-> getQuery()->getResult();
    }




}
