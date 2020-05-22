<?php

namespace GeneralBundle\Controller;

use Doctrine\ORM\Mapping\OrderBy;
use GeneralBundle\Entity\Produitbou;
use GeneralBundle\Entity\Rating;
use GeneralBundle\Entity\Store;
use GeneralBundle\Form\ProduitbouType;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Produitbou controller.
 *
 * @Route("produitbou")
 */
class ProduitbouController extends Controller
{

    public $nom ;

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }
    /**
     * Lists all produitbou entities.
     *
     * @Route("/", name="produitbou_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        //$produitbous = $em->getRepository('GeneralBundle:Produitbou')->findAll();
        $dql = "SELECT pb FROM GeneralBundle:Produitbou pb";
        $query = $em->createQuery($dql);

        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/index.html.twig', array(
            'produitbous' => $result,
        ));
    }

    /**
     * Lists produitbou entities.
     *
     * @Route("/search", name="produitbou_search")
     * @Method("GET")
     */
    public function RecherchePAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findAll();

        if($request->isMethod("GET"))
        {
            $key = $request->get('search');
            if($key)
            $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findBy(array('nom' => $key));

        }
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbous,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/searchP.html.twig', array(
            'produitbous' => $result,

        ));
    }
    /**
     * Lists produitbou entities.
     *
     * @Route("/searchPPS", name="produit_searchPPS")
     * @Method("GET")
     */

    public function RecherchePPSAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if($request->isMethod("GET"))
        {
            $key = $request->get('search1');
            if ($key !== '') {
                $store = $em->getRepository('GeneralBundle:Store')->findBy(array('nom' => $key ));
                $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findBy(array('idStore' => $store));
            }


        }
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbous,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/searchPPS.html.twig', array(
            'produitbous' => $result,

        ));
    }

    /**
     * @Route("/asearch",name="ajax_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts =  $em->getRepository('GeneralBundle:Produitbou')->findEntitiesByString($requestString);
        if(!$posts) {
            $result['posts']['error'] = "Aucun produit avec ce nom :( ";
        } else {
            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($posts){
        foreach ($posts as $posts){
            $realEntities[$posts->getId()] = [$posts->getNom(),$posts->getPrix()];

        }
        return $realEntities;
    }


    /**
     * Lists all produitbou entities.
     *
     * @Route("/bikes", name="produitbou_bikes")
     * @Method("GET")
     */
    public function BikesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findBy(array('categorie' => 'bike'));
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbous,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/bikes.html.twig', array(
            'produitbous' => $result,
        ));
    }

    /**
     * Lists all gears.
     *
     * @Route("/gears", name="produitbou_gears")
     * @Method("GET")
     */
    public function GearsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produitbous = $em->getRepository('GeneralBundle:Produitbou')->findBy(array('categorie' => 'accessories'));
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbous,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );

        return $this->render('produitbou/gears.html.twig', array(
            'produitbous' => $result,
        ));
    }
    /**
     * Lists produitbou entities.
     *
     * @Route("/a", name="a")
     * @Method("GET")
     */
    public function aAction(Request $request)
    {
        return $this->render('base.html.twig');

    }
    /**
     * Lists produitbou entities.
     *
     * @Route("/myproducts", name="produitbou_myproducts")
     * @Method("GET")
     */
    public function mesProduitsAction(Request $request)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $stores = $em->getRepository('GeneralBundle:Store')->findBy(array('owner' => $user ));
        $produits = $em->getRepository('GeneralBundle:Produitbou')->findBy(array('idStore' => $stores ));
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produits,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );
        return $this->render('produitbou/mesProduits.html.twig', array(
            'produits' => $result,
        ));
    }



    public function produitsEnReptureDeStockAction(Request $request){
        $em=$this->getDoctrine()->getManager();

        $produitbou=$em->getRepository('ProduitBundle:Produit')->findProduitsEnReptureDeStock();
        $paginator= $this->get('knp_paginator');
        $result=$paginator->paginate(
            $produitbou,
            $request->query->getInt('page', 1), /*page number*/
            $request->query->getInt('limit',5) /*limit per page*/
        );
        return $this->render('produitbou/produitsEnReptureDeStock.html.twig',array('produits'=>$result));
    }

    /**
     *
     * @Route("/ajouter")
     * @Method("POST")
     */
    public function ajouterProduitAction(Request $request)
    {
        $produit=new Produitbou();
        $form=$this->createForm(ProduitbouType::class,$produit,array('user' => $this->getUser()));
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            /** @var UploadedFile $file */
            $file = $produit->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$filename
            );
            $produit->setImage($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            $this->addFlash('success','Produit Ajouter');

            return $this->redirectToRoute('produitbou_afficher',  array('id' => $produit->getId()));
        }
        return $this->render('produitbou/new.html.twig', array(
            'produitbou' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/addproduits/add", name="addprod")
     */
    public function addProduitAction(Request $request){
        $store = $request->get("store");
        $nom = $request->get("nom");
        $description = $request->get("description");
        $prix = $request->get("prix");
        $qte = $request->get("qte");
        $catg = $request->get("catg");
        $img = $request->get("img");
        $produit = new Produitbou();
        $Store = $this->getDoctrine()->getRepository('GeneralBundle:Store')->findOneBy(['nom'=> $store]);
        $produit->setIdStore($Store);
        $produit->setNom($nom);
        $produit->setDescription($description);
        $produit->setPrix($prix);
        $produit->setQtetotal($qte);
        $produit->setCategorie($catg);
        $produit->setImage($img);
        $this->setNom($request->get('img'));
        $ex="succes";
        $em = $this->getDoctrine()->getManager();
        $em->persist($produit);
        $em->flush();
        $this->addRatingAction($nom,1);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($ex);
        return new JsonResponse($formatted);
    }

    public function addRatingAction($produit,$user){

        $rating = new Rating();
        $Produit = $this->getDoctrine()->getRepository('GeneralBundle:Produitbou')->findOneBy(['nom'=> $produit]);
        $User = $this->getDoctrine()->getRepository('GeneralBundle:User')->findOneBy(['id'=> $user]);
        $rating->setProduitbou($Produit);
        $rating->setUser($User);
        $rating->setRat(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rating);
        $em->flush();
    }


    /**
     * @Route("/addproduit/add/img", name="addimagee")
     */
    public function imgAction(Request $request)
    {
        $photo=$request->get('photo');
        $nom = $request->get("nom");
        $fich = $request->files->get($photo);
        //  $new_name = rand() . '.' . $fich->getClientOriginalExtension();
         $fich->copy($this->getParameter('Produitbou'),$nom);
         $serializer = new Serializer([new ObjectNormalizer()]) ;
         $formatted = $serializer->normalize($photo) ;
         return new JsonResponse($formatted) ;

    }

    /**
     * Lists all produits entities.
     *
     * @Route("/all/produits" , name="produits_all")
     */
    public function AllProduitbousAction()
    {
        $Produits = $this->getDoctrine()->getManager()
            ->getRepository('GeneralBundle:Produitbou')
            ->findProducts();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Produits);

        return new JsonResponse($Produits);
    }

    /**
     * Lists all produits entities.
     *
     * @Route("/storee/produits" , name="produitsbystore")
     */
    public function ProduitsByStoreAction(Request $request)
    {
        $store = $request->get('store');
        $Store = $this->getDoctrine()->getRepository('GeneralBundle:Store')->findOneBy(['id'=> $store]);
        $Produits = $this->getDoctrine()->getManager()
            ->getRepository('GeneralBundle:Produitbou')
            ->findBy(array('idStore' => $Store));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Produits);

        return new JsonResponse($formatted);
    }

    /**
     * Lists search entities.
     *
     * @Route("/search/produit" , name="produitsearch")
     */
    public function SearchProduitAction(Request $request)
    {
        $key = $request->get('search');
        $Produits = $this->getDoctrine()->getManager()
            ->getRepository('GeneralBundle:Produitbou')
            ->findBy(array('nom'=> $key));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($Produits);

        return new JsonResponse($formatted);
    }



    /**
     * Finds and displays a produitbou entity.
     *
     * @Route("/{id}", name="produitbou_show")
     * @Method("GET")
     */
    public function showAction(Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);

        return $this->render('produitbou/show.html.twig', array(
            'produitbou' => $produitbou,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a produitbou entity.
     *
     * @Route("/{id}/afficher", name="produitbou_afficher")
     * @Method("GET")
     */
    public function afficherPAction(Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);
        $authCheker=$this->container->get('security.authorization_checker');
        $em=$this->getDoctrine()->getManager();
        $existe=0;
        $rat=1;
        $i=1;
        if ($authCheker->isgranted ('ROLE_USER')){
            $userid=$this->get('security.token_storage')->getToken()->getUser()->getId();
            $ratings=$em->getRepository('GeneralBundle:Rating')->findAll();
            foreach ($ratings as $rating) {
                if ( (($rating->getProduitbou()->getId()) == $produitbou->getId()) && (($rating->getUser()->getId()) == $userid)  ) {
                    $existe=1;
                    $rat=$rating->getRat();
                }
            }
        }
        if ($existe==0) {
            $ratings = $em->getRepository('GeneralBundle:Rating')->findAll();

            foreach ($ratings as $rating) {
                if($rating->getProduitbou()->getId()==$produitbou->getId()){
                    $rat=$rat+$rating->getRat();
                    $i=$i+1;
                }
            }
            $rat=$rat / $i;
            if($rat>1 && $rat<=2){
                $rat=2;
            }
            else if($rat>2 && $rat <= 3){
                $rat=3;
            }elseif ($rat>3 && $rat <= 4){
                $rat=4;
            }elseif ($rat==1)
            {
                $rat=1;
            }
            else{
                $rat=5;
            }
        }

        return $this->render('produitbou/afficherProduit.html.twig', array(
            'produitbou' => $produitbou,
            'rat'=>$rat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produitbou entity.
     *
     * @Route("/{id}/edit", name="produitbou_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produitbou $produitbou)
    {
        $deleteForm = $this->createDeleteForm($produitbou);
        $editForm = $this->createForm('GeneralBundle\Form\ProduitbouType', $produitbou, array('user' => $this->getUser()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /** @var UploadedFile $file */
            $file = $produitbou->getImage();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$filename
            );
            $produitbou->setImage($filename);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','votre produit a éte édité avec success! ');

            return $this->redirectToRoute('produitbou_edit', array('id' => $produitbou->getId()));
        }

        return $this->render('produitbou/edit.html.twig', array(
            'produitbou' => $produitbou,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produitbou entity.
     *
     * @Route("/{id}", name="produitbou_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produitbou $produitbou)
    {
        $form = $this->createDeleteForm($produitbou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produitbou);
            $em->flush();
            $this->addFlash('success','Votre produit a été supprimer!');
        }

        return $this->redirectToRoute('produitbou_index');
    }



    /**
     * Creates a form to delete a produitbou entity.
     *
     * @param Produitbou $produitbou The produitbou entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produitbou $produitbou)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produitbou_delete', array('id' => $produitbou->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
