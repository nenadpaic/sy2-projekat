<?php
namespace Users\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class UserRepo extends EntityRepository{

   public function activateByToken($token){
       $db = $this->getQueryBuilder()
           ->where('p.active = 0')
           ->andWhere('p.token = :token')
           ->setParameter('token', $token)
           ->getQuery();
       $user = $db->getOneOrNullResult();
       return $user;

   }


    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:User')
            ->createQueryBuilder('p');
        return $qb;
    }

}