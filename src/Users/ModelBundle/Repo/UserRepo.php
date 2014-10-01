<?php
namespace Users\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class UserRepo extends EntityRepository{




    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:User')
            ->createQueryBuilder('p');
    }

}