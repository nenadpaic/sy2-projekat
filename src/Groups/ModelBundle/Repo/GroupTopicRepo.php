<?php
namespace Groups\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GroupTopicRepo extends EntityRepository
{
    /**
     * @param $group
     * @return int
     *
     * Returning number topics in group
     */
    public function countGroupTopics($group){
        $db = $this->getQueryBuilder()
            ->where("p.group = :group")
            ->setParameter("group", $group)
            ->getQuery();
        $topics = $db->getResult();

        return count($topics);
    }

    /**
     * @param $group
     * @return array|string
     *
     * Returning topics with all data
     */
    public function listAllTopics($group){
        $db = $this->getQueryBuilder()
            ->where("p.group = :group")
            ->setParameter("group", $group)
            ->getQuery();
        $topics = $db->getResult();
        if($topics)
            return $topics;
        return "";
    }



    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('GroupsModelBundle:GroupTopic')
            ->createQueryBuilder('p');
        return $qb;
    }

}