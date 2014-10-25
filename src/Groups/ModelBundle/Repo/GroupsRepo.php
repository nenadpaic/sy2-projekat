<?php
namespace Groups\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GroupsRepo extends EntityRepository{

    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:Groups')
            ->createQueryBuilder('p');
        return $qb;
    }

}