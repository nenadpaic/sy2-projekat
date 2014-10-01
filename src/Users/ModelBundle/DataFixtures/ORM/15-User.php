<?php

namespace Users\ModelBundle\DataFixtures\ORM;

use Users\ModelBundle\Entity\User as E_user;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * Fixtures ORM for Roles
 */

class User extends AbstractFixture implements OrderedFixtureInterface{

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

    }
}