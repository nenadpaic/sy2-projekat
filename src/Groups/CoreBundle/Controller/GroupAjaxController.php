<?php
namespace Groups\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Groups\ModelBundle\Entity\Groups;
use Groups\ModelBundle\Entity\GroupUsers;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GroupAjaxController extends Controller{
    /**
     * @Route("/groups/user-status-group/", name="user-status-group",defaults={"_locale"="en"} ,
     * requirements={ "_locale" = "en|mk"})
     */
    public function user_status_group(Request $request){
        //If request is not ajax,returning error
        if (!$request->isXMLHttpRequest()) {
            return new Response('This is not ajax!', 400);
        }
        $data = $request->request->all();
        $group_id = (int) $data['group_id'];
        $action = (int) $data['action'];
        $em = $this->getDoctrine()->getManager();

        //Checking if user is logged in
        $securityContext = $this->container->get('security.context');
        if(!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')){
            return $this->redirect($this->generateUrl('login'));
        }

        $user_s = $this->get('security.context')->getToken()->getUser();
        $userId = $user_s->getId();
        //Collecting data for user and group
        $user = $this->getDoctrine()->getManager()->getRepository('ModelBundle:User')->findOneBy(
            array('id' => $userId)
        );
        //Collecting group data and checking it
        $group = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:Groups')->findOneBy(
            array('id' => $group_id)
        );
        if(!$group)
            return new Response('There is an error,please try again later!', 400);
        //Checking if there is record in base
        $group_users = $em->getRepository('GroupsModelBundle:GroupUsers')->findOneBy(array(
            'user' => $user, 'group' => $group
        ));
        //If action is 0, creating new entry, user send request
        if($action == 0){
            if($group_users)
                return new Response('There is an error,please try again later!', 400);

            $group_s = new GroupUsers();
            $group_s->setGroup($group);
            $group_s->setUser($user);
            $group_s->setActive(0);
            $em->persist($group_s);
            $em->flush();

            $response = new JsonResponse();
            $response->setData(array(
                'message' => 'You have successfully sent request'
            ));
            return $response;
        }
        //else checking if user is in group and deleting entry
        if($action == 1){
            if(!$group_users)
                return new Response('There is an error,please try again later!', 400);
            $em->remove($group_users);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array(
                'message' => 'You have successfully left group'
            ));
            return $response;

        }
        return new Response('There is an error,please try again later!', 400);
    }

    /**
     * @Route("/groups/group-upload-timeline/", name="group-upload-timeline",defaults={"_locale"="en"} ,
     * requirements={ "_locale" = "en|mk"})
     */

    public function group_upload_timeline(Request $request){
        if (!$request->isXMLHttpRequest()) {
            return new Response('This is not ajax!', 400);
        }
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->all();
        $group_id = (int) $data['group'];
        $image = $request->files->get('image');
        $action = $data['action'];

        $response = new JsonResponse();

        $group = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:Groups')->findOneBy(
            array('id' => $group_id)
        );
        //Validation, checkin group, is there image, size, mime type and name
        $valid_extensions = array("image/jpeg", "image/jpg","image/png");
        if(!in_array($action,array(1,2)))
            return new Response('There is an error,please try again later!', 400);
        if(!$group)
            return new Response('There is an error,please try again later!', 400);
        if((!$image instanceof UploadedFile) || ($image->getError() != 0))
            return new Response('There is an error,please try again later!', 400);
        if($image->getSize() > 2097152)
            return new Response('Your image is to big, please try again!', 400);
        if(!in_array($image->getMimeType(),$valid_extensions))
            return new Response('Your image type is not valid, please try again!', 400);
        $pattern = "/^[a-zA-Z0-9-_. ]+$/";
        if(!preg_match($pattern,$image->getClientOriginalName()))
            return new Response('Image name can containt alphanumeric characters and .-_ symbols only!', 400);
        if(strlen($image->getClientOriginalName()) > 200)
            return new Response('Image name can not be longer than 200 chars!', 400);
        //Getting new name
        $new_cover_name = mt_rand() . $image->getClientOriginalName();

        //If action is 1, then it is cover,else it is logo image
        if($action == 1){
            if($group->getGroupCover()){
                if(is_file($this->getUploadDirCover($group->getId(),$group->getGroupCover()))){
                    unlink($this->getUploadDirCover($group->getId(),$group->getGroupCover()));
                }
            }
            $group->setGroupCover($new_cover_name);
        }
        elseif($action == 2){
            if($group->getGroupLogo()){
                if(is_file($this->getUploadDirCover($group->getId(),$group->getGroupLogo()))){
                    unlink($this->getUploadDirCover($group->getId(),$group->getGroupLogo()));
                }
            }
            $group->setGroupLogo($new_cover_name);
        }
        $em->persist($group);
        $em->flush();

        $file = $image->move($this->getUploadRootDir() . "uploads/groups/" . $group->getId(), $new_cover_name);
        $response->setData(array(
            "message" => "Image succesfully uploaded",
            "file" => "/uploads/groups/" . $group->getId() ."/".  $new_cover_name
        ));
        return $response;
    }

    /**
     * @Route("/groups/group-accept-request/", name="group-accept-request",defaults={"_locale"="en"} ,
     * requirements={ "_locale" = "en|mk"})
     */
    function group_accept_request(Request $request){
        if (!$request->isXMLHttpRequest()) {
            return new Response('This is not ajax!', 400);
        }
        $data = $request->request->all();
        $group_id = (int) $data['group'];
        $user_id = (int) $data['user'];
        $action = (int) $data['action'];
        $response = new JsonResponse();

        //Getting Repos and validating them
        $group = $this->getDoctrine()->getManager()->getRepository('GroupsModelBundle:Groups')->findOneBy(
            array('id' => $group_id)
        );
        if(!$group)
            return new Response('There is an error,please try again later!', 400);
        $user = $this->getDoctrine()->getManager()->getRepository('ModelBundle:User')->findOneBy(array('id' =>
            $user_id));
        if(!$user)
            return new Response('There is an error,please try again later!', 400);
        if(!in_array($action, array(0,1)))
            return new Response('There is an error,please try again later!', 400);

        $em = $this->getDoctrine()->getManager();
        $group_users = $em->getRepository('GroupsModelBundle:GroupUsers')->findOneBy(array(
            'user' => $user, 'group' => $group
        ));
        if(!$group_users)
            return new Response('There is an error,please try again later!', 400);

        //If action == 0, removing user from requests, else adding user
        if($action == 0){
            $em->remove($group_users);
            $em->flush();
            $response->setData(array(
                'message' => 0
            ));
            return $response;
        }
        elseif($action == 1){
            $group_users->setActive(1);
            $em->persist($group);
            $em->flush();
            $response->setData(array(
                'message' => 1
            ));
            return $response;
        }
        return new Response('There is an error,please try again later!', 400);
    }

    /**
     * @return string
     *
     * Getting root dir
     */
    private function getUploadRootDir(){
        return __DIR__.'/../../../../web/';
    }

    /**
     * @param $group_id
     * @param $name
     * @return string
     *
     * Getting direct location of images
     */
    private function getUploadDirCover($group_id, $name){
        return $this->getUploadRootDir() . "uploads/groups/" . $group_id . "/" . $name;
    }
}
