<?php
namespace Users\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class DocumentsRepo extends EntityRepository{

    /**
     * @param $userId
     * @return array
     */
    public function lastFiveDocuments($userId)
    {
        $qb = $this->getQueryBuilder()
            ->where('p.user = :user_id')
            ->setParameter('user_id', $userId)
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery();
        $documents = $qb->getResult();
        return $documents;
    }

    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:Documents')
            ->createQueryBuilder('p');
        return $qb;
    }
}