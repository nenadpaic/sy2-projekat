<?php

namespace Groups\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/groups", name="groups", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Template("GroupsCoreBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('GroupsModelBundle:Groups')->findAll();

        return array(
            'groups' => $groups
        );
    }

    /**
     * @Route("/group/{slug}", name="group", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk",
     * "slug" = "[a-z0-9-]+"})
     * @Template("GroupsCoreBundle:Default:single_group.html.twig")
     */

    public function showGroup($slug){
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('GroupsModelBundle:Groups')->findOneBy(array("slug" => $slug));

        if(!$group){
            $translated = $this->get('translator')->trans('groups.not_found');
            throw $this->createNotFoundException($translated);
        }
        return array(
            'group' => $group
        );

    }
}
