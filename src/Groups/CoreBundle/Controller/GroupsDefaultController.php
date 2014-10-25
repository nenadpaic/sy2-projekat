<?php

namespace Groups\CoreBundle\Controller;

use Groups\CoreBundle\Form\GroupNewTopicType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Groups\ModelBundle\Entity\Groups;
use Groups\ModelBundle\Entity\GroupUsers;
use Groups\ModelBundle\Entity\GroupTopic;
use Groups\CoreBundle\Form\NewGroupType;

class GroupsDefaultController extends Controller
{
    /**
     * @Route("/groups", name="groups", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Template("GroupsCoreBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        //Creating form for creating new groups
        $group = new Groups();
        $group_users = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:GroupUsers');
        $form = $this->createForm(new NewGroupType(), $group);
        //Checking request
        $request = $this->get('request');
        $form->handleRequest($request);
        //Taking user_id
        $user_s = $this->get('security.context')->getToken()->getUser();

        $securityContext = $this->container->get('security.context');
        //If request is POST and pass validation
        if($request->getMethod() == 'POST' && $form->isValid()){
            if(!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){
                return $this->redirect($this->generateUrl('login'));
            }
            $userId = $user_s->getId();
            $user = $this->getDoctrine()->getManager()->getRepository('ModelBundle:User')->findOneBy(
                array('id' => $userId)
            );

            //Inserting new group in DB
            $group->setUser($user);
            $group->setName($form->get('name')->getData());
            $group->setDescription($form->get('description')->getData());
            $group->setGroupLogo("");
            $group->setGroupCover("");
            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            //Inserting admin user
            $group_s = new GroupUsers();
            $group_s->setGroup($group);
            $group_s->setUser($user);
            $group_s->setActive(10);
            $em->persist($group_s);
            $em->flush();
            //Redirecting to new group
            return $this->redirect($this->generateUrl('group', array('slug' => $group->getSlug())));
        }
        //Listing all groups
        $em = $this->getDoctrine()->getManager();
        $groups = $em->getRepository('GroupsModelBundle:Groups')->findAll();

        return array(
            'groups' => $groups,
            'form' => $form->createView(),
            'group_users' => $group_users,

        );
    }

    /**
     * @Route("/group/{slug}", name="group", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk",
     * "slug" = "[a-z0-9-]+"})
     * @Template("GroupsCoreBundle:Default:single_group.html.twig")
     *
     * Displaying Individual group
     */

    public function showGroupAction($slug){
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('GroupsModelBundle:Groups')->findOneBy(array("slug" => $slug));

        if(!$group){
            $translated = $this->get('translator')->trans('groups.not_found');
            throw $this->createNotFoundException($translated);
        }
        $group_users = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:GroupUsers');
        $group_topics = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:GroupTopic');

        $user_s = $this->get('security.context')->getToken()->getUser();
        $securityContext = $this->container->get('security.context');
        $is_user_logged_in = $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED');

        $topic = new GroupTopic();
        $form = $this->createForm(new GroupNewTopicType(), $topic);
        //Checking request
        $request = $this->get('request');
        $form->handleRequest($request);
        if($request->getMethod() == 'POST' && $form->isValid()) {
            if(!$is_user_logged_in)
            {
                return $this->redirect($this->generateUrl('login'));
            }

            if($group_users->isMemberOfGroup($group,$user_s) != 1)
                return $this->redirect($this->generateUrl('groups'));

            $topic->setTitle($form->get('title')->getData());
            $topic->setMessage($form->get('message')->getData());
            $topic->setGroup($group);
            $topic->setUser($user_s);
            $em->persist($topic);
            $em->flush();
            return $this->redirect($this->generateUrl('group-topic',
                array('slug' => $group->getSlug(),
                    'topic_id' => $topic->getId(),
                )));
        }
        if($group_users->isAdminOfGroup($group,$user_s))
            $reported = 0;
        else{
            $report = $this->getDoctrine()->getManager()->getRepository('ReportModelBundle:Reports');
            $reported = $report->isReported($user_s,1,$group->getId());

        }

        return array(
            'group' => $group,
            'group_users' => $group_users,
            'group_topic' => $group_topics,
            'new_topic_form' => $form->createView(),
            'reported' => $reported
        );
    }

    /**
     *
     * @Route("/group/{slug}/{topic_id}", name="group-topic", defaults={"_locale"="en"} ,
     * requirements={ "_locale" = "en|mk","slug" = "[a-z0-9-]+", "topic_id" = "[0-9]+"})
     * @Template("GroupsCoreBundle:Default:single_topic.html.twig")
     */
    public function showTopicPageAction($slug,$topic_id){
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository("GroupsModelBundle:Groups")->findOneBy(array("slug" => $slug));
        //Checking for group and topic, do they exist
        if(!$group){
            $translated = $this->get('translator')->trans('groups.not_found');
            throw $this->createNotFoundException($translated);
        }
        $group_topic = $em->getRepository("GroupsModelBundle:GroupTopic")->findOneBy(array("id" => $topic_id,
            "group" => $group));
        if(!$group_topic){
            $translated = $this->get('translator')->trans('groups.topic_not_found');
            throw $this->createNotFoundException($translated);
        }

        //Checking if user is looged in and is he member of group
        $securityContext = $this->container->get('security.context');
        if(!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))
        {
            return $this->redirect($this->generateUrl('login'));
        }
        $user_s = $this->get('security.context')->getToken()->getUser();
        $group_users = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:GroupUsers');
        if($group_users->isMemberOfGroup($group,$user_s) != 1)
        {
            return $this->redirect($this->generateUrl('groups'));
        }

        $group_users = $em->getRepository("GroupsModelBundle:GroupUsers")->findBy(array("group" => $group));
        $group_comments = $em->getRepository("GroupsModelBundle:GroupTopicComment")->findBy(array("group_topic" =>
            $group_topic));
        return array(
            'group' => $group,
            'topic' => $group_topic,
            'group_users' => $group_users,
            'group_comments' => $group_comments
        );
    }
}
