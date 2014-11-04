<?php

namespace Users\DocumentsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Users\ModelBundle\Entity\Documents;
use Users\ModelBundle\Form\DocumentsType;

class DocumentsController extends Controller
{
    /**
     * @Route("/documents", name="documents_all", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     * show all documents
     */
    public function indexAction(Request $request)
    {
        $id = $request->query->getInt('user_id');
        $userId = ($id == null)? $this->get('security.context')->getToken()->getUser()->getId() : (int) $id;
        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository('ModelBundle:Documents')->findBy(array('user' => $userId));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $documents,
            $request->query->get('page',1),10

        );
        return array(
                'documents' => $pagination
            );    }

    /**
     * @Route("/documents/new", name="upload_document", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * upload new document
     */
    public function uploadAction(Request $request)
    {

        $userId =  $this->get('security.context')->getToken()->getUser()->getId();
        $documents = new Documents();

        $form = $this->createForm(new DocumentsType(), $documents, array('action' => $this->generateUrl('upload_document')) );

        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('ModelBundle:User')->find($userId);
            /** @var User $user */
            $documents->setUser($user);
            $documents->upload();

            $em->persist($documents);
            $em->flush();

            return $this->redirect($this->generateUrl('documents_all'));

        }

        return array(
                'form' =>$form->createView()
            );    }

    /**
     * @Route("/documents/delete", name="deleteDoc", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"POST"})
     * @Template()
     * @param Request $request
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\Security\Core\Exception\AccessDeniedException
     * Delete document form db and filesystem
     */
    public function deleteAction(Request $request)
    {
        if(! $request->isXmlHttpRequest()){
            return $this->createAccessDeniedException("Wrong type of request");
        }
        $data = $request->request->all();
        $documentId = (int) $data['document_id'];
        $em = $this->getDoctrine()->getManager();
        $document = $em->getRepository('ModelBundle:Documents')->find($documentId);
        if(!$document){
            return $this->createNotFoundException("That document do not exists");
        }
        $userId =  $this->get('security.context')->getToken()->getUser()->getId();
        if($document->getUser()->getId() != $userId ){
            return $this->createAccessDeniedException("You can not delete this");
        }
        $document->removeProfileImg();
        $em->remove($document);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array('message' => 'Successfully deleted document'));
        return $response;
   }

}
