<?php
namespace Groups\ModelBundle\Repo;

use Doctrine\ORM\EntityRepository;

class GroupUsersRepo extends EntityRepository{

    /**
     * @param $group
     * @return int
     *
     * Returning number of members of group
     */
    public function countGroupUsers($group){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT u.id FROM GroupsModelBundle:GroupUsers u WHERE u.group = :group AND(u.active = 1 OR u.active = 10)');
        $query->setParameter('group', $group);
        $groups = $query->getResult();

        return count($groups);
    }

    /**
     * @param $group
     * @param $user
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * Checking if user is member of group, admin or what...
     */
    public function checkUserStatus($group,$user){
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT u.active FROM GroupsModelBundle:GroupUsers u WHERE u.group = :group
        AND u.user = :user");
        $query->setParameter('group', $group);
        $query->setParameter('user', $user);

        $query1 = $query->getOneOrNullResult();
        //If there are no results, he is not in group
        if(!$query1)
            return 0;
        //If active == 0, user has send request but hasn't been accepted
        if($query1['active'] === 0)
            return 1;
        //If Active == 1, user is member of group
        if($query1['active'] === 1)
            return 2;
        //If active == 10, user is creator of group
        if($query1['active'] === 10)
            return 3;
        else
            return 0;
    }

    /**
     * @param $group
     * @param $user
     * @return int
     *
     * Checking if user is admin of group
     */
    public function isAdminOfGroup($group,$user){
        $db = $this->getQueryBuilder()
            ->where("p.group = :group")
            ->andWhere("p.user = :user")
            ->andWhere("p.active = 10")
            ->setParameter("group", $group)
            ->setParameter("user", $user)
            ->getQuery();
        $groups = $db->getResult();
        if($groups)
            return 1;
        return 0;
    }

    public function isMemberOfGroup($group,$user){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT u FROM GroupsModelBundle:GroupUsers u
                                    WHERE u.group = :group
                                    AND u.user = :user
                                    AND(u.active = 1 OR u.active = 10)');
        $query->setParameter("group", $group);
        $query->setParameter("user", $user);
        $groups = $query->getResult();
        if($groups)
            return 1;
        return 0;
    }

    /**
     * @param $group
     * @return array|string
     *
     * Returning list of users in group
     */
    public function listAllUsersGroup($group){
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT u FROM GroupsModelBundle:GroupUsers u
                                    WHERE u.group = :group
                                    AND(u.active = 1 OR u.active = 10)');
        $query->setParameter("group", $group);
        $users = $query->getResult();
        if($users)
            return $users;
        return "";
    }

    /**
     * @param $group
     * @return array|string
     *
     * Listing all pending requests
     */
    public function listAllPendingRequestsGroup($group){
        $db = $this->getQueryBuilder()
            ->where("p.group = :group")
            ->andwhere("p.active = 0")
            ->setParameter("group", $group)
            ->getQuery();
        $users = $db->getResult();
        if($users){
            return $users;
        }
        return "";
    }

    private function getQueryBuilder(){
        $em = $this->getEntityManager();
        $qb = $em->getRepository('GroupsModelBundle:GroupUsers')
            ->createQueryBuilder('p');
        return $qb;
    }
}