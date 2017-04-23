<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Student;
use AppBundle\Entity\StudyGroup;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * StudyGroupRepository
 *
 * This class was generated by the PhpStorm "Php Annotations" Plugin. Add your own custom
 * repository methods below.
 */
class StudyGroupRepository extends EntityRepository
{
    public function findByGroups(array $groups, $page = 1)
    {
        $studyGroups = $this->queryByGroups($groups)->getResult();
        $students = [];
        foreach ($studyGroups as $group)
        {
            foreach ($group->getStudents() as $student)
            {
                if (!in_array($student,$students,true))
                {
                    $students[] = $student;
                }
            }
        }
        $paginator = new Pagerfanta(new ArrayAdapter($students));
        $paginator->setMaxPerPage(Student::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    private function queryByGroups($groups)
    {
            $queryBuilder = $this->getEntityManager()->getRepository('AppBundle:StudyGroup')->createQueryBuilder('g');
                foreach ($groups as $key => $group) {
                    $queryBuilder->orWhere('g.name LIKE ?'.$key)
                        ->setParameter($key, $group);
                }
               return $queryBuilder->getQuery();

    }
}
