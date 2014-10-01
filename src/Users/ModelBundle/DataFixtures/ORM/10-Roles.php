<?php

namespace Users\ModelBundle\DataFixtures\ORM;

use Users\ModelBundle\Entity\Roles as Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * Fixtures ORM for Roles
 */

class Roles extends AbstractFixture implements OrderedFixtureInterface{

    /*
     * {@inheritDoc}
     */
    public function getOrder(){
        return 10;
    }
    /*
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager){
        $role1 = new Role();
        $role1->setRoleName('admin');

        $role2 = new Role();
        $role2->setRoleName('user');

        $manager->persist($role1);
        $manager->persist($role2);

        $manager->flush();
    }



}