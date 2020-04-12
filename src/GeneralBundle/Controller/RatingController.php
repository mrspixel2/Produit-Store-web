<?php

namespace GeneralBundle\Controller;

use GeneralBundle\Entity\Rating;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
}
