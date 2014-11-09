<?php

namespace Users\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Users\ModelBundle\Entity\User;
use Users\ModelBundle\Form\ChangePassType;
use Users\ModelBundle\Form\ProfileInfoType;
use Users\ModelBundle\Form\ProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ProfileController extends Controller
{
    /**
     * @Route("/user-profile", name="public_profile", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     *
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array
     */
    public function indexAction(Request $request)
    {

        $id = $request->query->getInt('id');
        $userId = ($id == null)? $this->get('security.context')->getToken()->getUser()->getId() : (int) $id;
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);
        
        $documents = $em->getRepository('ModelBundle:Documents')->lastFiveDocuments($userId);
        $nonce = md5(uniqid(rand(time(), true)));
        $session = $request->getSession();
        $session->set('nonce', $nonce);




        return array(
            'user' => $user,

            'documents' => $documents,
            'nonce' => $nonce
        );
    }

    /**
     * @Route("/user-profile-timeline", name="public_profile_timeline", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     *
     */
    public function timelineAction(Request $request)
    {
        $user_sess = $this->get('security.context')->getToken()->getUser();
        $userId = $user_sess->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);

        $form = $this->createForm(new ProfileType(), $user, array('action' => $this->generateUrl('public_profile_timeline')));

        $form->handleRequest($request);
        if($form->isValid()) {
            $user->removeTimelineImg();
            $upload = $user->upload();
            $user->setTimeLineImage($upload);

            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'Your changes has been saved');
            return $this->redirect($this->generateUrl('public_profile'));

        }


        return array(
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/user-profile-image", name="public_profile_img", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function profileAction(Request $request)
    {
        $user_sess = $this->get('security.context')->getToken()->getUser();
        $userId = $user_sess->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);

        $form = $this->createForm(new ProfileType(), $user, array('action' => $this->generateUrl('public_profile_img')));

        $form->handleRequest($request);
        if($form->isValid()) {
            $user->removeProfileImg();
            $upload = $user->upload();
            $user->setProfileImage($upload);


            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'Your changes has been saved');
            return $this->redirect($this->generateUrl('public_profile'));

        }


        return array(
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/user-profile-data", name="public_profile_data", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function dataAction(Request $request)
    {
        $user_sess = $this->get('security.context')->getToken()->getUser();
        $userId = $user_sess->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);

        $form = $this->createForm(new ProfileInfoType(), $user, array('action' => $this->generateUrl('public_profile_data')));

        $form->handleRequest($request);
        if($form->isValid()) {
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'Your changes has been saved');
            return $this->redirect($this->generateUrl('public_profile'));
        }



        return array(
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/user-profile-pass", name="public_profile_pass", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET", "POST"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function passAction(Request $request)
    {
        $user_sess = $this->get('security.context')->getToken()->getUser();
        $userId = $user_sess->getId();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ModelBundle:User')->find($userId);

        $form = $this->createForm(new ChangePassType(), $user, array('action' => $this->generateUrl('public_profile_pass')));

        $form->handleRequest($request);
        if($form->isValid()) {
            $factory = $this->get('security.encoder_factory');
            $password = $form->get('password')->getData();
            $encoder = $factory->getEncoder($user);
            $password1 = $encoder->encodePassword($password, $user->getSalt());
            $user->setPassword($password1);
            $em->persist($user);
            $em->flush();
            $this->get('session')->getFlashBag()->add('message', 'Your changes has been saved');
            return $this->redirect($this->generateUrl('public_profile'));
        }



        return array(
            'form' => $form->createView(),
            'user' => $user
        );
    }

    /**
     * @Route("/api/get/galeries", name="get_galeries_api", defaults={"_locale"="en"} ,requirements={ "_locale" = "en|mk"})
     * @Method({"GET"})
     * @Template()
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function getLastSixAction(Request $request){
        $id = $request->query->getInt('user_id');

        $userId = (int) $id;

        $em = $this->getDoctrine()->getManager();
        $galeries = $em->getRepository('ModelBundle:Galery')->lastFiveGaleries($userId);
        $response = new JsonResponse();
        if(!$galeries){

            $response->setData(array('status' => 'No galeries'));
            return $response;
        }
        $json = array();
        foreach($galeries as $g){
            $picture = $em->getRepository('ModelBundle:Pictures')->findOneBy(array('galery' => $g->getId()));
            
            $data = array('id' => $g->getId(), 'name' => $g->getName(), 'lastpic' => (!$picture)? "" : $this->container->get('templating.helper.assets')->getUrl($picture->profileImageDir()));
            array_push($json, $data);
        }
        $response->setData($json);
        return $response;
        
    }


}
