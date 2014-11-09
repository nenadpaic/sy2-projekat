<?php
namespace Users\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class RoleRepo extends EntityRepository{
    public function findbyId($id){

    }


    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:User')
            ->createQueryBuilder('p');
    }

}