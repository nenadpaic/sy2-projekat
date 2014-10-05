<?php

namespace Users\UsersCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UsersController extends Controller
{
    /**
     * @Route("/user/profile")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

}
