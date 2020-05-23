<?php

namespace GeneralBundle\Controller;

use GeneralBundle\Entity\Produitbou;
use GeneralBundle\Entity\User;
use GeneralBundle\Form\ProduitbouType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class DefaultController extends Controller
{
    /**
     * @Route("/general")
     */
    public function indexAction()
    {
        return $this->render('GeneralBundle:Default:index.html.twig');
    }

    /**
     * @Route("/general/user/{id}")
     */
    public function UserAction($id)
    {
        $user = $this->getDoctrine()->getRepository('GeneralBundle:User')->find($id) ;
        $serializer = new Serializer([new ObjectNormalizer()]) ;
        $formatted = $serializer->normalize($user) ;
        return new JsonResponse($formatted) ;
    }




}
