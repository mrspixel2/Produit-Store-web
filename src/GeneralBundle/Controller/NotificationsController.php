<?php

namespace GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NotificationsController extends Controller
{
    public function displayAction()
    {
        $notifications = $this->getDoctrine()->getManager()->getRepository('GeneralBundle:Notification')->findAll();
        return $this->render('@General/Notification/display.html.twig', array(
            'notifications' => $notifications
        ));
    }
}
