<?php
namespace Users\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GaleryRepo extends EntityRepository{

    /**
     * @param $user_id
     * GET last 5 galeries
     * @return array
     */
    public function lastFiveGaleries($user_id){
        $qb = $this->getQueryBuilder()
            ->where('p.user = :user_id')
            ->setParameter('user_id', $user_id)
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery();

        $galery = $qb->getResult();

        return $galery;
    }


    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:Galery')
            ->createQueryBuilder('p');
        return $qb;
    }

}