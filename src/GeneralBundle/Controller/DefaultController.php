<?php

namespace GeneralBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/general")
     */
    public function indexAction()
    {
        return $this->render('GeneralBundle:Default:index.html.twig');
    }
}
