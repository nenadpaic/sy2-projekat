<?php

namespace Users\GaleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Users\ModelBundle\Entity\Pictures;
use Users\ModelBundle\Form\PictureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PicturesController extends Controller
{
    /**
     * @Route("/galery/{galery_id}/upload/image", name="upload_image_galery",  defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk", "galery_id" = "[0-9]+"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @param $galery_id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * Upload image to galery
     */
    public function uploadAction(Request $request, $galery_id)
    {
        $em = $this->getDoctrine()->getManager();
        $picture = new Pictures();
        $galery = $em->getRepository('ModelBundle:Galery')->find($galery_id);
        /** @var object $galery */
        $picture->setGalery($galery);
        $form = $this->createForm(new PictureType(), $picture, array('action' => $this->generateUrl('upload_image_galery', array('galery_id' => $galery_id))));
        $form->handleRequest($request);
        if($form->isValid()){
            $picture->upload();
            $em->persist($picture);
            $em->flush();
            return $this->redirect($this->generateUrl('show_galery', array('id' => $galery_id)));

        }
        return array(
                'form' => $form->createView()
            );
    }

    /**
     * @Route("/galery/image/delete", name="delete_image_galery")
     * @Template()
     * @param Request $request
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * Delete image from galery
     */
    public function deleteAction(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            throw $this->createAccessDeniedException("Wrong type of request");
        }
        $data = $request->request->all();
        $id = (int) $data['picture_id'];
        $em = $this->getDoctrine()->getManager();
        $picture = $em->getRepository('ModelBundle:Pictures')->find($id);
        if(!$picture){
            throw $this->createNotFoundException("That picture does not exist");
        }
        $picture->removeProfileImg();
        $em->remove($picture);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array(
           'message' => 'Successfuly deleted picture from galery'
        ));
        return $response;

    }

}
