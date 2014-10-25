<?php
namespace Report\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ReportAjaxController extends Controller
{
    /**
     * @Route("/report/{component_id}/{component}/{choice}", name="report_user",
     * requirements={"component_id" = "[0-9]+", "component" = "[0-9]+", "choice" = "[0-9]+"})
     */
    public function reportAction($component_id, $component, $choice)
    {

    }
}