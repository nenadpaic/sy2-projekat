<?php

namespace Users\GaleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Users\ModelBundle\Entity\Galery;
use Users\ModelBundle\Form\GaleryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class GaleryController extends Controller
{
    /**
     * @Route("/galeries", name="galeries", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Template()
     * @param Request $request
     * @return array
     * Shows all user galeries
     */
    public function indexAction(Request $request)
    {
        $id = $request->query->get('user_id');
        $userId = ($id == null)? $this->get('security.context')->getToken()->getUser()->getId() : (int) $id;
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('ModelBundle:User')->find($userId);

        $galeries = $user->getImages();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $galeries,
            $request->query->get('page',1),10

        );

        return array(
                'galeries' => $pagination,
                'user' => $userId
            );
    }

    /**
     * @Route("/galery/new", name="create_new_galery", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * Create new galery
     * @var int user_id
     */
    public function createAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);
        $galery = new Galery();
        $form = $this->createForm(new GaleryType(), $galery, array('action' => $this->generateUrl('create_new_galery')));
        $form->handleRequest($request);
        if($form->isValid()){
            $galery->setUser($user);
            $em->persist($galery);
            $em->flush();

            return $this->redirect($this->generateUrl("galeries"));
        }

        return array(
                'form' => $form->createView()
            );
    }

    /**
     * @Route("/delete/galery/{id}", name="delete_galery", requirements={"id" = "[0-9]+"})
     * @Template()
     * @param Request $request
     * @param $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * Delete galery
     */
    public function deleteAction(Request $request, $id)
    {
        $galeryId = (int) $id;

        $form = $this->createDeleteForm($galeryId);

        $form->handleRequest($request);
        if($form->isValid() ){
            $em = $this->getDoctrine()->getManager();
            $galery = $em->getRepository('ModelBundle:Galery')->find($galeryId);
            $userId = $this->get('security.context')->getToken()->getUser()->getId();
            if(!$galery) {
                throw $this->createNotFoundException("That galery does not exist");
            }
            if($galery->getUser()->getId() == $userId){
                $pictures = $galery->getPictures();
                foreach($pictures as $p){
                    $p->removeProfileImg();
                }
                $em->remove($galery);
                $em->flush();
               return  $this->redirect($this->generateUrl('galeries'));
            }
            }


        }




    /**
     * @Route("/galery/{id}", name="show_galery", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk", "id" = "[0-9]+"})
     * @Method({"GET"})
     * @Template()
     */
    public function showAction(Request $request,$id)
    {
        $galeryId = $id;
        $em = $this->getDoctrine()->getManager();
        $galery = $em->getRepository('ModelBundle:Galery')->find($galeryId);
        if(!$galery){
            throw $this->createNotFoundException("That galery does not exist");
        }
        $pictures = $galery->getPictures();
        $form = $this->createDeleteForm($galery->getId());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $pictures,
            $request->query->get('page',1),10

        );
        return array(
               'pictures' => $pagination,
               'galery' => $galery,
               'delete_form' => $form->createView()
            );
    }
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_galery', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }

}
