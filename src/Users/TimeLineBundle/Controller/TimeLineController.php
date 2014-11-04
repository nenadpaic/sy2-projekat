<?php

namespace Users\TimeLineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TimeLineController extends Controller
{
    /**
     * @Route("/index", name="timelineAll")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $nonce_s = $request->getSession()->get('nonce');
        $nonce = $request->get('nonce');


        if($nonce_s != $nonce){
            return $this->createAccessDeniedException('Access denied');
        }


        $id = $request->get('user_id');

        $userId = ($id == null)? $this->get('security.context')->getToken()->getUser()->getId() : (int) $id;
        $em = $this->getDoctrine()->getManager();
        $timeline = $em->getRepository('ModelBundle:TimeLine')->getTimeLinePosts($userId);
        $links = "";


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $timeline,
            $request->query->get('page',1),10

        );
       $json = array();

        foreach($pagination as $p){
            $edit = false;
            $delete = false;
            $report = true;
            $create = true;
            if($p->getUser()->getId() == $this->get('security.context')->getToken()->getUser()->getId() || $this->get('security.context')->isGranted("ROLE_ADMIN") ){
                $edit = true;
                $delete = true;
            }
            $data = array('id'=> $p->getId(), 'user_id' => $p->getUser()->getId(),'user' => $p->getUser()->getUsername(),'content' => strip_tags($p->getContent()), 'createdAt' => $p->getCreatedAt(), 'updatedAt' => $p->getUpdatedAt(), 'edit' => $edit, 'delete' => $delete, 'report' => $report, 'create' => $create );
            array_push($json, $data);
        }

        $resposnse = new JsonResponse();
        $resposnse->setData($json);
        return $resposnse;


    }

    /**
     * @Route("/edit", name="edit_timeline")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request)
    {
        $nonce_s = $request->getSession()->get('nonce');
        $nonce = $request->get('nonce');
        $em = $this->getDoctrine()->getManager();
        if ($nonce_s != $nonce) {
            return $this->createAccessDeniedException('Access denied');
        }
        if($request->isMethod('GET')) {

            $post_id = (int)$request->get('post_id');

            $post = $em->getRepository('ModelBundle:TimeLine')->findOneBy(array('id' => $post_id));
            if (!$post) {
                return $this->createNotFoundException('No such post');
            }
            if ($this->get('security.context')->getToken()->getUser()->getId() != $post->getUser()->getId() || !$this->get('security.context')->isGranted("ROLE_ADMIN")) {
                return $this->createAccessDeniedException('You have no access');
            }

            $response = new JsonResponse();
            $response->setData(array('content' => strip_tags($post->getContent()), 'id' => $post->getId()));
            return $response;
        }
        if($request->isMethod('POST')){
            $post_id = (int) $request->get('post_id');
            $content = strip_tags($request->get('content'));
            $post = $em->getRepository('ModelBundle:TimeLine')->findOneBy(array('id' => $post_id));
            if (!$post) {
                return $this->createNotFoundException('No such post');
            }
            if ($this->get('security.context')->getToken()->getUser()->getId() != $post->getUser()->getId() || !$this->get('security.context')->isGranted("ROLE_ADMIN")) {
                return $this->createAccessDeniedException('You have no access');
            }
            $post->setContent($content);
            $em->persist($post);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array('status' => true));
            return $response;

        }

    }





    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction()
    {
        return array(
            // ...
        );    }

}
