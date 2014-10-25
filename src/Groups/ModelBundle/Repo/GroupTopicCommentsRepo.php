<?php
namespace Groups\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GroupTopicCommentsRepo extends EntityRepository{

    /**
     * @param $topic_id
     * @return array
     *
     * Returning all comments from topic
     */
    public function list_all_comments($topic_id){
        $db = $this->getQueryBuilder()
            ->where("p.topic = :topic")
            ->setParameter("topic", $topic_id)
            ->getQuery();
        $replies = $db->getResult();
        return $replies;

    }

    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('ModelBundle:Groups')
            ->createQueryBuilder('p');
        return $qb;
    }

}