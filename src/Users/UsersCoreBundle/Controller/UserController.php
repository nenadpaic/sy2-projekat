<?php

namespace Users\UsersCoreBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Users\ModelBundle\Entity\User;
use Users\ModelBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/admin/user")
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     * @Route("/", name="admin_user")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dbl = $em->getRepository('ModelBundle:User');
        $query = $dbl->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page',1), 10
        );



        return array(
            'entities' => $pagination,
        );
    }
    /**
     * Creates a new User entity.
     *
     * @Route("/", name="admin_user_create")
     * @Method("POST")
     * @Template("UsersUsersCoreBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl("admin_user_show", array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModelBundle:User')->find($id);
        $roles = $em->getRepository('ModelBundle:Role')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'roles'       => $roles,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Method("GET")
     * @Template()
     * @param $id
     * @return array
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModelBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        /** @var User $id */
        $deleteForm = $this->createDeleteForm($id);
        $roles = $em->getRepository('ModelBundle:Role')->findAll();

        return array(
            'roles'       => $roles,
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="admin_user_update")
     * @Method("PUT")
     * @Template("UsersUsersCoreBundle:User:edit.html.twig")
     * @param Request $request
     * @param $id
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ModelBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        /** @var User $entity */
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ModelBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * Add role to user
     * @param Request $request
     * @throws \Exception
     * @internal param user_id $int , int role_id
     * @return JsonResponse
     * @Route("/add/role", name="admin_add_role")
     * @Method("POST")
     */
    public function addRoleToUserAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $data = $request->request->all();
            $roleId = (int) $data['role_id'];
            $userId = (int) $data['user_id'];
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('ModelBundle:Role')->findOneBy(array(
                'id' => $roleId
            ));
            if(!$role){
                throw $this->createNotFoundException('Such role does not exist');
            }
            $user = $em->getRepository('ModelBundle:User')->find($userId);
            if(!$user){
                throw $this->createNotFoundException('Such user does not exist');
            }
            $user->addRole($role);
            $em->persist($user);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array(
                'message' => 'Successfuly added role to user'
            ));

            return $response;
        }

        return new Response('This is not ajax!', 400);
    }

    /**
     * Removes role from user
     * @param Request $request
     * @throws \Exception
     * @internal param user_id $int , int role_id
     * @return JsonResponse
     * @Route("/remove/role", name="admin_remove_role")
     * @Method("POST")
     */
    public function removeRoleFromUserAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $data = $request->request->all();
            $roleId = (int) $data['role_id'];
            $userId = (int) $data['user_id'];
            $em = $this->getDoctrine()->getManager();
            $role = $em->getRepository('ModelBundle:Role')->findOneBy(array(
                'id' => $roleId
            ));
            if(!$role){
                throw $this->createNotFoundException('Such role does not exist');
            }
            $user = $em->getRepository('ModelBundle:User')->find($userId);
            if(!$user){
                throw $this->createNotFoundException('Such user does not exist');
            }
            $user->removeRole($role);
            $em->persist($user);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array(
                'message' => 'Successfuly removed role from user'
            ));

            return $response;
        }

        return new Response('This is not ajax!', 400);
    }
}
