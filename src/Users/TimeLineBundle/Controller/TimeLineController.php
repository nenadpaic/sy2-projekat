<?php

namespace Users\TimeLineBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Users\ModelBundle\Entity\TimeLine;

class TimeLineController extends Controller
{
    /**
     * @Route("/index", name="timelineAll")
     * @Template()
     * @param $nonce, int user_id
     * @return Json response
     * @throws createAccessDeniedException
     * Shows all TImeline posts from specific user
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

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $timeline,
            $request->query->get('page',1),10

        );

       $json = array();

        foreach($pagination as $p){
            $edit = false;
            $delete = false;

            $create = true;
            if($p->getUser()->getId() == $this->get('security.context')->getToken()->getUser()->getId() || $this->get('security.context')->isGranted("ROLE_ADMIN") ){
                $edit = true;
                $delete = true;
            }
            $data = array('id'=> $p->getId(), 'user_id' => $p->getUser()->getId(),'user' => $p->getUser()->getUsername(),'content' => strip_tags($p->getContent()), 'createdAt' => $p->getCreatedAt(), 'updatedAt' => $p->getUpdatedAt(), 'edit' => $edit, 'delete' => $delete,  'create' => $create );

            array_push($json, $data);
        }
        if(empty($json)){
            $resposnse = new JsonResponse();
            $resposnse->setData(array('status' => false));
            return $resposnse;
        }
        $resposnse = new JsonResponse();
        $resposnse->setData(array('page' => $json));
        return $resposnse;


    }

    /**
     * @Route("/edit", name="edit_timeline")
     * @Method({"GET", "POST"})
     * @param Request
     * @param $nonce , int post in
     * @throws createAccessDeniedException
     * @throws createNoFoundException
     * @return JSON response
     * Shows or update specific post
     * 
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
        	$params = array();
        	$content = $this->get('request')->getContent();
        	if(!empty($content)){
        		$params = json_decode($content,true);
        	}
        	$current_user = $this->get('security.context')->getToken()->getUser()->getId();
        	$perm = $this->get('security.context')->isGranted("ROLE_ADMIN");
        	//calls update post method
        	$update = $this->updateTimeline($params, $current_user, $em, $perm);
        	$response = new JsonResponse();
        	$response->setData(array('status' => $update));
        	return $response;
        }

    }
	
	/**
	 * @param array $params, int $current_user, object $em, bool $perm
	 * @throws createNotFoundException, createAccessDeniedException
	 * @return bool true if updated Post
	 * Update post method
	 */
	private function updateTimeline($params, $current_user, $em, $perm){
		$post_id = (int) $params['post_id'];
		
		$content = strip_tags($params['content']);
		
		
		$post = $em->getRepository('ModelBundle:TimeLine')->findOneBy(array('id' => $post_id));
		if (!$post) {
			return $this->createNotFoundException('No such post');
		}
		if ($current_user != $post->getUser()->getId() || !$perm) {
			return $this->createAccessDeniedException('You have no access');
		}
		$post->setContent($content);
		$em->persist($post);
		$em->flush();
		return true;
	}



    /**
     * @Route("/delete", name="delete_timeline")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request)
    {
    	$nonce_s = $request->getSession()->get('nonce');
    	$nonce = $request->get('nonce');
    	$em = $this->getDoctrine()->getManager();
    	if ($nonce_s != $nonce) {
    		return $this->createAccessDeniedException('Access denied');
    	}
    	if(!$request->isMethod('POST')){
    		return $this->createAccessDeniedException('Access denied');	
    	}
    	$params = array();
    	$content = $this->get('request')->getContent();
    	if(!empty($content)){
    		$params = json_decode($content,true);
    	}
    	$post_id = (int) $params['post_id'];
    	$post = $em->getRepository('ModelBundle:TimeLine')->findOneBy(array('id' => $post_id));
    	if(!$post){
    	 return $this->createNotFoundException('No such post');
    	}
    	if ($this->get('security.context')->getToken()->getUser()->getId() != $post->getUser()->getId() || !$this->get('security.context')->isGranted("ROLE_ADMIN")) {
                return $this->createAccessDeniedException('You have no access');
        }
    	$em->remove($post);
    	$em->flush();
    	$response = new JsonResponse();
        $response->setData(array('status' => true)); 
        return $response;  
    }

    /**
     * @Route("/create", name="create_timeline")
     * @Method({"POST"})
     * @Template()
     */
    public function createAction(Request $request)
    {
    	$nonce_s = $request->getSession()->get('nonce');
    	$nonce = $request->get('nonce');
    	$em = $this->getDoctrine()->getManager();
    	if ($nonce_s != $nonce) {
    		return $this->createAccessDeniedException('Access denied');
    	}
    	if(!$request->isMethod('POST')){
    		return $this->createAccessDeniedException('Access denied');
    	}
    	$params = array();
    	$content = $this->get('request')->getContent();
    	if(!empty($content)){
    		$params = json_decode($content,true);
    	}
    	$content = strip_tags($params['content']);
    	$user_id = $this->get('security.context')->getToken()->getUser()->getId();
    	$user = $em->getRepository('ModelBundle:User')->findOneBy(array('id' => $user_id));
    	if(!$user){
    		return $this->createNotFoundException("There is not such user");
    	}
    	$post = new TimeLine();
    	$post->setUser($user);
    	$post->setContent($content);
		$em->persist($post);
		$em->flush();
		$response = new JsonResponse();
		$response->setData(array('status' => true));
		return $response;	
    }
}