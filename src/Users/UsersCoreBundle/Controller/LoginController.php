<?php

namespace Users\UsersCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Users\ModelBundle\Entity\Role;
use Users\ModelBundle\Entity\User;
use Users\ModelBundle\Form\UserType;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {
        return $this->redirect($this->generateUrl('register'));
        }
        $session = $request->getSession();
        if($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(
                SecurityContextInterface::AUTHENTICATION_ERROR
            );
        }
        elseif(null != $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);

        }
        else{
            $error = '';
        }
        $lastUsername = (null == $session)? '' : $session->get(SecurityContextInterface::LAST_USERNAME);
        return $this->render('UsersUsersCoreBundle:Login:login.html.twig',
            array(
               'last_username' => $lastUsername,
                'error'        => $error
            ));
    }


    /**
     * @Route("/register", name="register")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function registerAction(Request $request){
        $user = new User();
        $form = $this->createForm(new UserType(), $user, array('action' => $this->generateUrl('register')));
        $form->handleRequest($request);
        if($form->isValid() && $request->getMethod() == "POST"){
            $factory = $this->get('security.encoder_factory');
            $user = new User();
            $password = $form->get('password')->getData();
            $encoder = $factory->getEncoder($user);
            $password1 = $encoder->encodePassword($password, $user->getSalt());
            $user->setUsername($form->get('username')->getData());
            $user->setPassword($password1);
            $user->setEmail($form->get('email')->getData());
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $user->setCountry($form->get('country')->getData());
            $user->setState($form->get('state')->getData());
            $user->setCity($form->get('city')->getData());
            $user->setAddress($form->get('address')->getData());
            $user->setPhone($form->get('phone')->getData());
            $user->setIpAddress($_SERVER['REMOTE_ADDR']);
            $user->setActive(md5(uniqid(rand(), true)));
            $user->setCreatedAt(new \DateTime());
            $user->setLastLogin(new \DateTime());
            $role = $this->getDoctrine()->getManager()->getRepository('ModelBundle:Role')->findOneBy(
              array('id' => 1)
            );
            $user->addRole($role);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();



        }
        return $this->render('UsersUsersCoreBundle:Login:register.html.twig', array('form' => $form->createView()));
    }




}
