<?php
namespace Groups\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GroupTopicCommentRepliesRepo extends EntityRepository{

    /**
     * @param $comment_id
     * @return array
     *
     * Returning all comment replies
     */
    public function list_all_comment_replies($comment_id){
        $db = $this->getQueryBuilder()
            ->where("comment = :comment")
            ->setParameter("comment", $comment_id)
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