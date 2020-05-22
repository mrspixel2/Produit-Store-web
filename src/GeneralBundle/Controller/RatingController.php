<?php

namespace GeneralBundle\Controller;

use GeneralBundle\Entity\Rating;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RatingController extends Controller
{
    /**
     *
     *
     * @Route("/rating", name="produit_rating")
     * @Method("GET")
     */
    public function ratingAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $rat =$request->get('rat');
        $idproduit =$request->get('id');
        $iduser=$this->get('security.token_storage')->getToken()->getUser()->getId();
        $produit=$em->getRepository('GeneralBundle:Produitbou')->find($idproduit);
        $ratings=$em->getRepository('GeneralBundle:Rating')->findAll();
        $existe=0;
        foreach ($ratings as $rating) {
            if ( ($rating->getProduitbou()->getId() == $idproduit) && (($rating->getUser())->getId() == $iduser)  ) {
                $rating->setRat($rat);
                $em->persist($rating);
                $em->flush();
                $existe=1;
            }
        }
        if ($existe==0){
            $rating=new Rating();
            $rating->setRat($rat);
            $rating->setUser($this->get('security.token_storage')->getToken()->getUser());
            $rating->setProduitbou($produit);
            $em->persist($rating);
            $em->flush();
        }
        return $this->redirectToRoute('produitbou/afficherProduit.html.twig');
        // return $this->render('@Produit/Default/clientViews/index.html.twig', array('existe' => $existe));
    }

    /**
     * @Route("/rating/add", name="add_rating")
     */
    public function addRatingAction(Request $request){

        $produit = $request->get('idproduit');
        $user = $request->get('iduser');
        $rate = $request->get('rate');
        $rating = new Rating();
        $Produit = $this->getDoctrine()->getRepository('GeneralBundle:Produitbou')->findOneBy(['id'=> $produit]);
        $User = $this->getDoctrine()->getRepository('GeneralBundle:User')->findOneBy(['id'=> $user]);
        $rating->setProduitbou($Produit);
        $rating->setUser($User);
        $rating->setRat($rate);
        $ex="succes";
        $em = $this->getDoctrine()->getManager();
        $em->persist($rating);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }

    /**
     * @Route("/rating/prod", name="get_rating")
     */
    public function getRatingAction(Request $request){

        $produit = $request->get('idproduit');
        $Produit = $this->getDoctrine()->getRepository('GeneralBundle:Produitbou')->findOneBy(['id'=> $produit]);
        $rat = $this->getDoctrine()->getRepository('GeneralBundle:Rating')->findproduitrate($Produit);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($rat);
        return new JsonResponse($formatted);
    }

}
