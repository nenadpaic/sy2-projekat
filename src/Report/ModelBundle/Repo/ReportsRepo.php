<?php
namespace Report\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class ReportsRepo extends EntityRepository{

    /**
     * Checking if user has submitted report
     * @param $user
     * @param $component
     * @param $component_id
     * @return int
     */
    public function isReported($user,$component,$component_id)
    {
        if(!is_object($user))
            return 0;
        $reports = $this->getQueryBuilder()
            ->where("r.user_reporting = :user")
            ->andWhere("r.component = :component")
            ->andWhere("r.componentId = :component_id")
            ->setParameter("user",$user->getId())
            ->setParameter("component",$component)
            ->setParameter("component_id",$component_id)
            ->getQuery();
        $rep = $reports->getResult();
        if($rep)
            return 1;
        return 2;
    }

    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ReportModelBundle:Reports')
            ->createQueryBuilder('r');
        return $qb;
    }

}