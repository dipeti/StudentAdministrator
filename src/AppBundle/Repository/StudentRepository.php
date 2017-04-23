<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class StudentRepository extends EntityRepository
{
    public function findAll($page = 1)
    {
        $paginator = new Pagerfanta(new ArrayAdapter(parent::findAll()));
        $paginator->setMaxPerPage(Student::NUM_ITEMS);
        $paginator->setCurrentPage($page);
        return $paginator;
    }


    /**
     * @param $name
     * @param int $page
     * @return Pagerfanta
     */
    public function findByName($name, $page = 1)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryByName($name), false));
        $paginator->setMaxPerPage(Student::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }


    /**
     * @param $name
     * @return \Doctrine\ORM\Query
     */
    private function queryByName($name)
    {
        return $this->getEntityManager()->getRepository('AppBundle:Student')
            ->createQueryBuilder('s')
            ->innerJoin('s.studyGroups','g')
            ->where('s.name LIKE :name')
            ->setParameter('name','%'.$name.'%')
            ->getQuery();
    }




}
